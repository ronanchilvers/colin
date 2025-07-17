<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kanban Board</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <style>
    body { font-family: sans-serif; margin: 0; padding: 1rem; background: #f4f4f4; }
    .board { display: flex; gap: 1rem; }
    .column { flex: 1; background: #fff; padding: 1rem; border-radius: 8px; min-height: 300px; }
    .column h2 { margin-top: 0; }
    .card { background: #e0e0e0; margin: 0.5rem 0; padding: 0.5rem; border-radius: 4px; cursor: pointer; }
    .add-card { margin-top: 1rem; }
    input, textarea { width: 100%; padding: 0.5rem; margin-top: 0.25rem; }
    .modal {
      position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
    }
    .modal-content {
      background: white; padding: 1rem; border-radius: 8px; width: 300px;
    }
    .modal-content h3 { margin-top: 0; }
    .modal-content button { margin-top: 0.5rem; }
  </style>
</head>
<body>
<div id="app">
  <div class="board">
    <div class="column" v-for="(cards, column) in board" :key="column">
      <h2>{{ column }}</h2>
      <div :id="`list-${column}`" class="card-list">
        <div v-for="(card, index) in cards" :key="card.id" class="card" @click="openCard(column, index)">
          <strong>{{ card.title }}</strong><br/>
          <small v-if="card.content">{{ card.content.slice(0, 30) }}...</small>
        </div>
      </div>
      <div class="add-card">
        <input v-model="newCard[column]" @keyup.enter="addCard(column)" placeholder="Add card title..." />
      </div>
    </div>
  </div>

  <div class="modal" v-if="editingCard">
    <div class="modal-content">
      <h3>Edit Card</h3>
      <label>Title:</label>
      <input v-model="editingCard.card.title" />
      <label>Content:</label>
      <textarea rows="5" v-model="editingCard.card.content"></textarea>
      <button @click="closeEditor">Close</button>
    </div>
  </div>
</div>

<script>
const { createApp, reactive, ref, onMounted } = Vue;

createApp({
  setup() {
    const board = reactive({
      "Todo": [],
      "In Progress": [],
      "Review": [],
      "Done": []
    });

    const newCard = reactive({
      "Todo": "", "In Progress": "", "Review": "", "Done": ""
    });

    const editingCard = ref(null);

    function addCard(column) {
      if (newCard[column].trim()) {
        board[column].push({
          id: Date.now() + Math.random(),
          title: newCard[column].trim(),
          content: ""
        });
        newCard[column] = "";
      }
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

    onMounted(() => {
      for (const column of Object.keys(board)) {
        new Sortable(document.getElementById(`list-${column}`), {
          group: 'kanban',
          animation: 150,
          onAdd(evt) {
            const oldCol = evt.from.getAttribute('id').replace('list-', '');
            const newCol = evt.to.getAttribute('id').replace('list-', '');

            const index = evt.oldIndex;
            const movedCard = board[oldCol].splice(index, 1)[0];
            board[newCol].splice(evt.newIndex, 0, movedCard);
          }
        });
      }
    });

    return { board, newCard, addCard, openCard, closeEditor, editingCard };
  }
}).mount("#app");
</script>
</body>
</html>
