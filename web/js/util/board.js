import { listenFor } from '/js/util/listenFor.js';
import { waitFor } from '/js/util/waitFor.js';

class Board {

    // constructor(headerSelector, containerSelector) {
    constructor(api, id, containerSelector) {
        // this.header = document.querySelector(headerSelector);
        this.api = api;
        this.id = id;
        this.containerSelector = '#column_container';
        // this.containerSelector = '#columns';
    }

    async load() {
        // Load the initial board data with `GET /api/board/{id}`
        const boardData = await this.api.loadBoard(this.id);
        let { board, columns, cards } = boardData.board;
        this.updateBoardHeader(board.title);
        columns.forEach(column => {
            this.addColumn(
                column.id,
                column.title
            );
        });
        Object.entries(cards).forEach(([columnId, cardArray]) => {
            cardArray.forEach(card => {
                this.addCard(
                    card.id,
                    columnId,
                    card.title
                );
            });
        });
    }

    async setupListeners() {
        const container = await waitFor(this.containerSelector);

        // Column removal
        listenFor(container, 'colin:column-remove', (e) => {
            this.deleteColumn(e.detail.column.id());
        });
    }

    updateBoardHeader(title) {
        const headerEl = document.querySelector('board-header');
        if (!headerEl) return;
        headerEl.setTitle(title);
    }

    async createColumn(title) {
        const data = await this.api.createColumn(
            this.id,
            {
                title: title
            }
        );
        console.log('board.createColumn');
        let { column } = data;
        this.addColumn(
            column.id,
            column.title
        );
    }

    addColumn(id, title) {
        const addColumnEl = document.querySelector(this.containerSelector + " .add-column");
        if (!document.querySelector(this.containerSelector) || !addColumnEl) return;
        const col = document.createElement('column-element');
        col.setAttribute('id', id);
        col.setTitle(title);
        (document.querySelector(this.containerSelector)).insertBefore(col, addColumnEl);
    }

    async removeColumn(id) {

    }

    deleteColumn(id) {
      this.api.deleteColumn(
        this.id,
        id
      ).then(() => {
        const colEl = document.querySelector('#col' + id);
        if (colEl && colEl.parentNode) {
            colEl.parentNode.remove();
        }
      });
    }

    // async createCard(columnId, title) {
    //     const data = await this.api.createCard(
    //         this.id,
    //         {
    //             column: columnId,
    //             title: title
    //         }
    //     );
    //     let { card } = data;
    //     this.addCard(
    //         card.id,
    //         card.title
    //     );
    // }

    async addCard(id, columnId, title) {
        const cardList = await waitFor('#col' + columnId + ' .card-list');
        if (!cardList) return;
        const card = document.createElement('card-element');
        card.setAttribute('id', id);
        card.setTitle(title);
        cardList.appendChild(card);
    }

    // moveCard(id, columnId) {
    //     const cardEl = document.querySelector('#card' + id);
    //     const columnEl = document.querySelector('#col' + columnId + ' .card-list');
    //     if (!cardEl || !columnEl) return;
    //     columnEl.appendChild(cardEl);
    // }
}

export default Board;
