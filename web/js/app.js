import Api from '/js/util/api.js';
import Board from '/js/util/board.js';

// window.api = new Api();
window.board = new Board(
    new Api(),
    '01983ae2-6526-72cd-8ce4-8b91ebd16688',
    '#column_container'
).load();
