const { createApp, reactive, ref, onMounted, nextTick } = Vue;

createApp({
  setup() {
    const boardId = ref(null);
    const boardTitle = ref("Board");
    const board = reactive({});

    const columns = ref([]);

    const newCard = reactive({});

    const editingCard = ref(null);
    const newColumnLabel = ref("");

    async function loadBoard(boardId) {
      try {
        const response = await fetch(`/api/board/${boardId}`);
        if (!response.ok) throw new Error("Failed to fetch board data");
        const data = await response.json();

        if (data.board.board) {
          boardTitle.value = data.board.board.title;
        }
        if (data.board.columns && data.board.cards) {
          columns.value = data.board.columns;
          columns.value.forEach(col => {
            board[col.id] = data.board.cards[col.id] || [];
            newCard[col.id] = { title: "", isAdding: false };
          });
        }
        nextTick(() => {
          columns.value.forEach(col => initSortable(col.id));
        });
      } catch (error) {
        console.error("Error loading board:", error);
      }
    }

    async function createColumn(boardId, column) {
      try {
        const response = await fetch(`/api/board/${boardId}/column`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ board: boardId, ...column })
        });
        if (!response.ok) throw new Error("Failed to save column");
        const result = await response.json();
        return { ...column, id: result.column.id };
      } catch (error) {
        console.error("Error saving column:", error);
        return null;
      }
    }

    async function deleteColumn(boardId, columnId) {
      try {
        const response = await fetch(`/api/board/${boardId}/column/${columnId}`, {
          method: 'DELETE'
        });
        if (!response.ok) throw new Error("Failed to delete column");
        return true;
      } catch (error) {
        console.error("Error saving column:", error);
        return null;
      }
    }

    async function createCard(boardId, columnId, card) {
      try {
        const response = await fetch(`/api/board/${boardId}/card`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ column: columnId, ...card })
        });
        if (!response.ok) throw new Error("Failed to save card");
        const result = await response.json();
        return { ...card, id: result.card.id };
      } catch (error) {
        console.error("Error saving card:", error);
        return null;
      }
    }

    async function updateCard(boardId, columnId, card) {
      try {
        await fetch(`/api/board/${boardId}/card/${card.id}`, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ column: columnId, ...card })
        });
      } catch (error) {
        console.error("Error updating card:", error);
      }
    }

    async function deleteCard(boardId, columnId, card) {
      try {
        await fetch(`/api/card/${card.id}`, {
          method: 'DELETE'
        });
        const idx = board[columnId].findIndex(c => c.id === card.id);
        if (idx !== -1) board[columnId].splice(idx, 1);
        editingCard.value = null;
      } catch (error) {
        console.error("Error deleting card:", error);
      }
    }

    async function updateColumnOrder(boardId, columns) {
      try {
        await fetch(`/api/board/${boardId}/column/order`, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ order: columns.map(col => col.id) })
        });
      } catch (error) {
        console.error("Error updating column order:", error);
      }
    }

    function startAdding(columnId) {
      newCard[columnId].isAdding = true;
      nextTick(() => {
        const inputs = document.querySelectorAll(`#list-${columnId} ~ .add-card input`);
        if (inputs.length) inputs[0].focus();
      });
    }

    function cancelAdd(columnId) {
      newCard[columnId].title = "";
      newCard[columnId].isAdding = false;
    }

    function addCard(columnId) {
      const title = newCard[columnId].title.trim();
      if (title) {
        createCard(boardId.value, columnId, { title, content: "" }).then(cardWithId => {
          if (cardWithId) {
            board[columnId].push(cardWithId);
          }
        });
      }
      newCard[columnId].title = "";
      newCard[columnId].isAdding = false;
    }

    function openCard(columnId, index) {
      editingCard.value = {
        column: columnId,
        index,
        card: board[columnId][index]
      };
    }

    function closeEditor() {
      if (editingCard.value) {
        updateCard(boardId.value, editingCard.value.column, editingCard.value.card);
      }
      editingCard.value = null;
    }

    function addColumn() {
      const title = newColumnLabel.value.trim();
      if (title) {
        createColumn(boardId.value, { title: title}).then(columnWithId => {
          const id = columnWithId.id
          if (!board[id]) {
            board[id] = [];
            newCard[id] = { title: "", isAdding: false };
            columns.value.push({ id, title: title });
            newColumnLabel.value = "";
            nextTick(() => {
              initSortable(id);
            });
          }
        });
      }
    }

    function removeColumn(columnId) {
      if (board[columnId] && board[columnId].length === 0 && columns.value.length > 1) {
        deleteColumn(boardId.value, columnId).then(result => {
          delete board[columnId];
          delete newCard[columnId];
          const index = columns.value.findIndex(col => col.id === columnId);
          if (index !== -1) columns.value.splice(index, 1);
          return true;
        });
      }
    }

    function canRemoveColumn(columnId) {
      return board[columnId] && board[columnId].length === 0 && columns.value.length > 1;
    }

    function initSortable(columnId) {
      new Sortable(document.getElementById(`list-${columnId}`), {
        group: 'kanban',
        animation: 150,
        ghostClass: 'ghost-card',
        onAdd(evt) {
          const oldCol = evt.from.getAttribute('id').replace('list-', '');
          const newCol = evt.to.getAttribute('id').replace('list-', '');

          const index = evt.oldIndex;
          const movedCard = board[oldCol].splice(index, 1)[0];
          board[newCol].splice(evt.newIndex, 0, movedCard);
          updateCard(boardId.value, newCol, movedCard);
        }
      });
    }

    onMounted(() => {
      const urlParts = window.location.pathname.split('/');
      boardId.value = urlParts[urlParts.length - 1] || urlParts[urlParts.length - 2];
      loadBoard(boardId.value);

      new Sortable(document.getElementById("column-container"), {
        animation: 150,
        handle: ".handle",
        onMove: (evt) => {
          return !evt.related.classList.contains("add-column");
        },
        onEnd(evt) {
          const moved = columns.value.splice(evt.oldIndex, 1)[0];
          columns.value.splice(evt.newIndex, 0, moved);
          updateColumnOrder(boardId.value, columns.value);
        }
      });
    });

    return {
      columns, boardTitle, board, newCard, addCard, openCard, closeEditor, editingCard,
      startAdding, cancelAdd, newColumnLabel, addColumn, removeColumn, canRemoveColumn,
      createCard, updateCard, deleteCard
    };
  }
}).mount("#app");
