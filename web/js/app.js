setTimeout(() => {
    [1,2,3].forEach(id => window.board.addColumn('col' + id, 'Column ' + id));
}, 10);
setTimeout(() => {
    [1, 2, 3, 4, 5,6,7,8,9,10].forEach(id => window.board.addCard('card' + id, 'col1', 'Card ' + id));
}, 50);
setTimeout(() => {
    window.board.moveCard('card1', 'col3');
    window.board.moveCard('card2', 'col2');
    window.board.moveCard('card3', 'col3');
    window.board.moveCard('card4', 'col2');
}, 100);
