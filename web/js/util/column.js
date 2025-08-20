import { boardStore } from './store.js'; // assuming your signal store is here

export function addColumn(id, label) {
  // Update the reactive data store
  boardStore.columns = [...boardStore.columns, { id, label }];
  boardStore.cards[id] = [];

  // Create a new column-element and attach to the DOM
  const columnContainer = document.querySelector('#column-container');
  if (!columnContainer) {
    console.warn('Column container not found in DOM');
    return;
  }

  const columnElement = document.createElement('column-element');
  columnElement.setAttribute('column-id', id);
  columnContainer.appendChild(columnElement);
}
