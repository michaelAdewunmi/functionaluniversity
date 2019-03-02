import jQuery from 'jquery';

class Search {
    constructor() {
        this.focusedInput = false;
        this.appendSearchOverlay();
        this.openButton = jQuery(".js-search-trigger");
        this.closeButton = jQuery(".search-overlay__close");
        this.searchOverlay = jQuery(".search-overlay");
        this.searchField = jQuery("#search-term");
        this.searchResultDiv = jQuery("#search-overlay__result");
        this.searchOverlayOpened;
        this.typingTimer;
        this.isSpinnerVisible = false;
        this.lastsearchFieldValue;

        this.events();
    }


    //events
    events() {
        var inputsArray = [...document.getElementsByTagName("input")]
        inputsArray.forEach(input => input.addEventListener("focusin", this.checkFocusIn.bind(this)));
        inputsArray.forEach(input => input.addEventListener("focusout", this.checkFocusOut.bind(this)));
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        jQuery(document).on("keydown", this.toggleSearchOverlay.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this))
    }

    checkFocusIn() {
        this.focusedInput = true;
    }
    checkFocusOut() {
        this.focusedInput = false;
    }


    //methods
    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        jQuery("body").addClass("body-no-scroll");
        this.searchOverlayOpened = true;
        setTimeout(()=>this.searchField.focus(), 400);
        return false;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        jQuery("body").removeClass("body-no-scroll");
        this.searchOverlayOpened = false;
        this.searchResultDiv.html("");
        this.searchField.val("");

    }

    //!jQuery('input').is('focus')

    toggleSearchOverlay(e) {
        if(e.keyCode==83 && !this.searchOverlayOpened && !this.focusedInput && !jQuery('input, textarea').is(':focus')) {
            this.openOverlay();
        }
        if(e.keyCode==27 && this.searchOverlayOpened) {
            this.closeOverlay();
        }
    }

    typingLogic() {
        if(this.searchField.val() != this.lastsearchFieldValue) {
            clearTimeout(this.typingTimer);
            if(this.searchField.val()) {
                if(!this.isSpinnerVisible) {
                    this.searchResultDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
            }else{
                this.searchResultDiv.html("");
                this.isSpinnerVisible = false;
            }
        }
        this.lastsearchFieldValue = this.searchField.val();
    }

    getResults() {

        jQuery.getJSON(`${fictionUniversityData.baseUrl}/wp-json/fictionaluniversity/v1/search?keyword=${this.searchField.val()}`, (results) => {
            this.searchResultDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information Result</h2>
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p><i>No General Information macthes the search item</i></p>'}
                        ${results.generalInfo.map(result => `<li><a href="${result.permalink}">${result.title}</a> ${result.postType=="post" ? ` - A post by ${result.authorName}` : '' }</li>`).join("")}
                        ${results.generalInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? '<ul class="link-list min-list">' : `<p><i>No Program matches the search item. <a href="${fictionUniversityData.baseUrl}/programs">View All Programs</a></i></p>`}
                        ${results.programs.map(result => `<li><a href="${result.permalink}">${result.title}</a></li>`).join("")}
                        ${results.programs.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length ? '<ul class="link-list min-list">' : `<p><i>No Campus matches the search item. <a href="${fictionUniversityData.baseUrl}/campuses">View All Campus</a></i></p>`}
                        ${results.campuses.map(result => `<li><a href="${result.permalink}">${result.title}</a></li>`).join("")}
                        ${results.campuses.length ? '</ul>' : ''}
                    </div>
                </div>
                <div class="row">
                    <div class="one-half">
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length ? '<ul class="professor-cards">' : `<p><i>No Pofessor matches the search item.</i></p>`}
                        ${results.professors.map(result => `
                            <li class="professor-card__list-item">
                                <a href="${result.permalink}" class="professor-card">
                                    <img src="${result.thumbnailUrl}" alt="" class="professor-card__image">
                                    <span class="professor-card__name">${result.title}</span>
                                </a>
                            </li>
                        `).join("")}
                        ${results.professors.length ? '</ul>' : ''}

                    </div>
                    <div class="one-half">
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length ? '' : `<p><i>No Events matches the search item. <a href="${fictionUniversityData.baseUrl}/events">View All Events</a></i></p>`}
                        ${results.events.map(result => `
                            <div class="event-summary">
                                <a class="event-summary__date t-center" href="${result.permalink}">
                                    <span class="event-summary__month">${result.eventMonth}</span>
                                    <span class="event-summary__day">${result.eventDay}</span>
                                </a>
                                <div class="event-summary__content">
                                    <h5 class="event-summary__title headline headline--tiny"><a href="${result.permalink}">${result.title}</a></h5>
                                    <p>${result.eventDescription} ... <a href="${result.permalink}" class="nu gray">Learn more</a></p>
                                </div>
                            </div>
                        `).join("")}
                    </div>
                </div>
            `)
        });

        this.isSpinnerVisible = false;
    }

    appendSearchOverlay() {
        jQuery("body").append(`
        <div class="search-overlay">
            <div class="search-overlay__top">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="What are you Looking For" id="search-term" />
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
            </div>
            <div class="container">
                <div id="search-overlay__result"></div>
            </div>
        </div>
        `)
    }
}

export default Search;