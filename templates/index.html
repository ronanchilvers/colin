<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kanban Board</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet" />
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <style>
    * {
        box-sizing: border-box;
    }
    html {
      line-height: 1;
      font-size: 16px;
    }
    body {
      font-family: sans-serif;
      margin: 0;
      background: rgb(13,99,177);
    }
    h1, h2, h3, h4 {
      padding: 0;
      margin: 0;
      font-size: 1rem;
      font-weight: 600;
    }
    input, textarea {
      font-size: 1rem;
      background-color: transparent;
      border: none;
    }
    input:focus, textarea:focus {
      outline: none;
    }
    header {
      padding: 1rem;
      background-color: rgb(10,82,145);
      color: rgb(255,255,255);
    }
    .board {
      margin: 1rem;
      display: flex;
      gap: 1rem;
      align-items: flex-start;
    }
    #app {
        overflow: auto;
    }
    .column {
      flex: 1;
      background: rgb(216,220,224);
      border-radius: 3px;
      /* min-height: 100px; */
      width: 250px;
      min-width: 250px;
      max-width: 250px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      color: rgb(42,42,42);
      box-shadow: 0px 2px 5px 0px rgba(9, 70, 127, 1);
    }
    .column h2 {
        margin: 0;
        display: flex;
        flex-direction: column;
        cursor: grab;
    }
    .column__header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0.75rem;
    }
    .control__remove {
        border: 0;
        background-color: transparent;
    }
    .column__content {
      padding: 0.75rem;
      padding-top: 0;
      flex-grow: 1;
    }
    .card-list {
      flex-grow: 1;
    }
    .card {
      background: #fff;
      color: rgb(100,100,100);
      margin: 0 0 0.5rem 0;
      padding: 0.75rem;
      border-radius: 3px;
      cursor: pointer;
      box-shadow: 0px 1px 3px 0px rgba(139, 149, 158, 0.5);
    }
    .card__header,
    .card__content {
      padding: 0.25rem;
    }
    .add-card {
      padding: 0.75rem;
      padding-top: 0;
    }
    .add-card a {
      color: rgb(134, 134, 134);
      text-decoration: none;
    }
    input, textarea {
      width: 100%;
      padding: 0rem;
    }
    .modal-dimmer {
      position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
    }
    .modal {
      background: rgb(216,220,224);
      padding: 1rem;
      border-radius: 3px;
      margin: auto auto;
      width: 80%;
      height: 80%;
      max-width: 800px;
      display: flex;
      gap: 1rem;
      flex-direction: column;
      justify-content: flex-start;
    }
    .modal__header,
    .modal__content {
      /* padding: 1rem; */
    }
    .modal__header input,
    .modal__content textarea {
      padding: 0.5rem;
      border-radius: 4px;
      font-family: sans-serif;
    }
    .modal__header input:focus,
    .modal__content textarea:focus {
      background-color: rgba(139, 149, 158, 0.5);
    }
    .modal__header {
      display: flex;
      gap: 1rem;
      flex-direction: row;
      justify-content: space-between;
    }
    .modal__header input {
      font-weight: 600;
    }
    .modal__title {
      flex-grow: 1;
    }
    .modal_controls {
      flex-grow: 0;
    }
    .modal__content {
      flex-grow: 1;
    }
    .modal__content textarea {
      height: 100%;
    }
    .ghost-card {
      opacity: 0.4;
      background: #bbb;
    }
    .handle {
      cursor: grab;
      user-select: none;
    }
    .ghost-column {
      opacity: 0.6;
      background: #ddd;
      justify-content: flex-start;
    }
    .ghost-column input,
    .ghost-column button {
      width: 100%;
    }
    .add-column {
      background: rgba(216,220,224, 0.3);
    }
    .add-column input {
      color: rgb(255,255,255);
    }
  </style>
</head>
<body>
    <header>
        <h1>Kanban board</h1>
    </header>
<div id="app">
  <div id="column-container" class="board">
    <div class="column" v-for="column in columns" :key="column">
      <div class="column__header">
        <h2 class="handle">
            {{ column }}
        </h2>
        <div class="column__control">
            <button v-if="canRemoveColumn(column)" @click="removeColumn(column)" class="control__remove">X</button>
        </div>
      </div>
      <div :id="`list-${column}`" class="column__content card-list">
        <div v-for="(card, index) in board[column]" :key="card.id" class="card" @click="openCard(column, index)">
          <div class="card__header">
            <h3>{{ card.title }}</h3>
          </div>
          <!-- <div class="card__content" v-if="card.content">
            {{ card.content.slice(0, 30) }}...
          </div> -->
        </div>
      </div>
      <div class="add-card">
        <div v-if="newCard[column].isAdding">
          <input v-model="newCard[column].title" @keyup.enter="addCard(column)" @blur="cancelAdd(column)" placeholder="Card title..." />
        </div>
        <div v-else>
          <a href="#" @click.prevent="startAdding(column)">Add a card...</a>
        </div>
      </div>
    </div>
    <div class="column add-column">
      <div class="column__header">
        <input v-model="newColumnName" placeholder="Add a column..." @keyup.enter="addColumn"/>
      </div>
    </div>
  </div>

  <div class="modal-dimmer" v-if="editingCard">
    <div class="modal">
      <div class="modal__header">
        <div class="modal__title">
          <input v-model="editingCard.card.title" />
        </div>
        <div class="modal__controls">
          <button @click="closeEditor">Close</button>
        </div>
      </div>
      <div class="modal__content">
        <textarea rows="5" v-model="editingCard.card.content"></textarea>
      </div>
    </div>
  </div>
</div>

<script>
const { createApp, reactive, ref, onMounted, nextTick } = Vue;

createApp({
  setup() {
    const board = reactive({
      "Todo": [],
      "In Progress": [],
      "Done": []
    });

    const columns = ref(["Todo", "In Progress", "Done"]);

    const newCard = reactive({
      "Todo": { title: "", isAdding: false },
      "In Progress": { title: "", isAdding: false },
      "Review": { title: "", isAdding: false },
      "Done": { title: "", isAdding: false }
    });

    const editingCard = ref(null);
    const newColumnName = ref("");

    async function loadBoard() {
      try {
        const response = await fetch('/api/board');
        if (!response.ok) throw new Error("Failed to fetch board data");
        const data = await response.json();

        if (data.columns && data.board) {
          columns.value = data.columns;
          Object.keys(data.board).forEach(col => {
            board[col] = data.board[col];
            newCard[col] = { title: "", isAdding: false };
          });
        }
        nextTick(() => {
          Object.keys(board).forEach(initSortable);
        });
      } catch (error) {
        console.error("Error loading board:", error);
      }
    }

    function addCard(column) {
      const title = newCard[column].title.trim();
      if (title) {
        board[column].push({
          id: Date.now() + Math.random(),
          title: title,
          content: ""
        });
      }
      newCard[column].title = "";
      newCard[column].isAdding = false;
    }

    function startAdding(column) {
      newCard[column].isAdding = true;
      nextTick(() => {
        const inputs = document.querySelectorAll(`#list-${column} ~ .add-card input`);
        if (inputs.length) inputs[0].focus();
      });
    }

    function cancelAdd(column) {
      newCard[column].title = "";
      newCard[column].isAdding = false;
    }

    function openCard(column, index) {
      editingCard.value = {
        column,
        index,
        card: board[column][index]
      };
    }

    function closeEditor() {
      editingCard.value = null;
    }

    function addColumn() {
      const name = newColumnName.value.trim();
      if (name && !(name in board)) {
        board[name] = [];
        newCard[name] = { title: "", isAdding: false };
        columns.value.push(name);
        newColumnName.value = "";
        nextTick(() => {
          initSortable(name);
        });
      }
    }

    function removeColumn(column) {
      if (board[column].length === 0 && columns.value.length > 1) {
        delete board[column];
        delete newCard[column];
        const index = columns.value.indexOf(column);
        if (index !== -1) columns.value.splice(index, 1);
      }
    }

    function canRemoveColumn(column) {
      return board[column].length === 0 && columns.value.length > 1;
    }

    function initSortable(column) {
      new Sortable(document.getElementById(`list-${column}`), {
        group: 'kanban',
        animation: 150,
        ghostClass: 'ghost-card',
        onAdd(evt) {
          const oldCol = evt.from.getAttribute('id').replace('list-', '');
          const newCol = evt.to.getAttribute('id').replace('list-', '');

          const index = evt.oldIndex;
          const movedCard = board[oldCol].splice(index, 1)[0];
          board[newCol].splice(evt.newIndex, 0, movedCard);
        }
      });
    }

    onMounted(() => {
      loadBoard();

      new Sortable(document.getElementById("column-container"), {
        animation: 150,
        handle: ".handle",
        onMove: (evt) => {
          return !evt.related.classList.contains("add-column");
        },
        onEnd(evt) {
          const moved = columns.value.splice(evt.oldIndex, 1)[0];
          columns.value.splice(evt.newIndex, 0, moved);
        }
      });
    });

    return {
      columns, board, newCard, addCard, openCard, closeEditor, editingCard,
      startAdding, cancelAdd, newColumnName, addColumn, removeColumn, canRemoveColumn
    };
  }
}).mount("#app");
</script>
</body>
</html>
