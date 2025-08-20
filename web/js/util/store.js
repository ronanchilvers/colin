import { signal } from '/js/vendor/reef.es.min.js';

export const store = signal({
  columns: [
      {
          id: "col1",
          title: "Column 1",
          cards: [
            "card1",
            "card2",
          ]
      },
      {
          id: "col2",
          title: "Column 2",
          cards: [
            "card3",
          ]
      },
      {
          id: "col3",
          title: "Column 3",
          cards: [
            "card4",
          ]
      },
  ],
  cards: {
      card1: {
        id: "card1",
        title: "Card 1",
      },
      card2: {
          id: "card2",
          title: "Card 2",
      },
      card3: {
          id: "card3",
          title: "Card 3",
      },
      card4: {
          id: "card4",
          title: "Card 4",
      },
  }
});

window.store = store;
