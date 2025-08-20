class Board {

    // constructor(headerSelector, containerSelector) {
    constructor(containerSelector) {
        // this.header = document.querySelector(headerSelector);
        this.containerSelector = containerSelector;
    }

    addColumn(id, title) {
        const col = document.createElement('column-element');
        col.setAttribute('id', id);
        col.setTitle(title);
        document.querySelector(this.containerSelector).appendChild(col);
    }

    addCard(id, column, title) {
        const card = document.createElement('card-element');
        card.setAttribute('id', id);
        card.setTitle(title);
        document.querySelector('#' + column + ' .card-list').appendChild(card);
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
