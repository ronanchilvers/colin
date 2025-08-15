import { signal, component } from '/js/vendor/reef.es.min.js';
import { bind } from '/js/util/bind.js';

function template() {
    return `
    <form class="login-form">
      <div class="login-form__header">

      </div>
      <div class="login-form__content">
        <input
          type="text"
          id="board_title"
          name="board_title"
          placeholder="Board title..."
          required="required"
          value="">
          <span>${board_title.value}</span>
        ${error.value.length > 0 ? `<div style="color: red; margin-top: 0.5em;">${errorMessage}</div>` : '' }
      </div>
      <div class="login-form__footer">
        <button type="submit" class="ok">Create</button>
      </div>
    </form>
    `;
}

let board_title = signal("");
let error = signal("");
let login = component(
    "#app",
    template
)

bind(
    board_title,
    "#board_title",
);

export default login;
