//import { signal, component } from '/js/vendor/reef.es.min.js';
// import login from '/js/component/login.js';

// login.render();

setTimeout(() => {
    ['1', '2', '3'].forEach(id => window.board.addColumn('col' + id, 'Column ' + id));
}, 1000);
setTimeout(() => {
    [1, 2, 3, 4, 5].forEach(id => window.board.addCard('card' + id, 'col1', 'Card ' + id));
}, 2000);
setTimeout(() => {
    window.board.moveCard('card1', 'col3');
    window.board.moveCard('card2', 'col2');
    window.board.moveCard('card3', 'col3');
    window.board.moveCard('card4', 'col2');
}, 3000);
