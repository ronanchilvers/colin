import { signal, component } from '/js/vendor/reef.es.min.js';
import { bind, bindForm } from '/js/util/bind.js';
import { if_true } from '/js/util/conditional.js';

function template() {
    return `
    <form id="js-login-form" class="login-form">
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
          ${board_title.value.length > 0 ? `<span>'${board_title.value}'</span>` : 'Enter a board title' }
        ${ if_true(
            error.value.length > 0,
            `<div style="color: red; margin-top: 0.5em;">${error.value}</div>`,
            ''
        ) }
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
bindForm(
    '#js-login-form',
    function (form) {
        console.log(form);
    }
);

export default login;
