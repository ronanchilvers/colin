import { api } from '/js/util/api.js';

class Board {

    // constructor(headerSelector, containerSelector) {
    constructor(containerSelector) {
        console.log(api);
        // this.header = document.querySelector(headerSelector);
        this.containerSelector = containerSelector;
    }

    load(id) {
        // Load the initial board data with `GET /api/board/{id}`
    }

    addColumn(id, title) {
        const container = document.querySelector(this.containerSelector);
        if (!container) return;
        const col = document.createElement('column-element');
        col.setAttribute('id', id);
        col.setTitle(title);
        container.appendChild(col);
    }

    addCard(id, column, title) {
        const cardList = document.querySelector('#' + column + ' .card-list');
        if (!cardList) return;
        const card = document.createElement('card-element');
        card.setAttribute('id', id);
        card.setTitle(title);
        cardList.appendChild(card);
    }

    moveCard(id, column) {
        const cardEl = document.querySelector('#' + id);
        const columnEl = document.querySelector('#' + column + ' .card-list');
        if (!cardEl || !columnEl) return;
        columnEl.appendChild(cardEl);
    }
}

// window.board = new Board('board-header header', '#column_container');
window.board = new Board('#column_container');
