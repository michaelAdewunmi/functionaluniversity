//import jQuery from 'jquery';

class Search {
    constructor() {
        this.openButton = document.getElementsByClassName("js-search-trigger");
        this.closeButton = document.getElementsByClassName("search-overlay__close");
        this.searchOverlay = document.getElementsByClassName("search-overlay");

        this.events();
        console.log(this.closeButton);
    }


    //events
    events() {
        for(let i=0; i<this.openButton.length; i++) {
            this.openButton[i].addEventListener("click", this.openOverlay.bind(this));
        }
        this.closeButton[0].addEventListener("click", this.closeOverlay.bind(this));
    }

    //methods
    openOverlay() {
        this.searchOverlay[0].classList.add("search-overlay--active");
    }

    closeOverlay() {
        this.searchOverlay[0].classList.remove("search-overlay--active");
    }
}

export default Search;