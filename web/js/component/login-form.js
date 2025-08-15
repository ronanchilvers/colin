import { signal, component } from '/js/vendor/reef.es.min.js';
import { bind, bindForm } from '/js/util/bind.js';
import { if_true } from '/js/util/conditional.js';

class LoginForm extends HTMLElement
{
    constructor () {
        super();
        component(
            this,
            this.template
        )
    }

    template () {
        return `
        <form method="POST" id="js-login-form" class="login-form">
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
                ${ if_true(
                    board_title.value.length > 0,
                    `<span>'${board_title.value}'</span>`,
                    'Enter a board title'
                ) }
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

}
customElements.define(
    'login-form',
    LoginForm
)

let board_title = signal("");
let error = signal("");

bind(
    board_title,
    "#board_title",
);
bindForm(
    '#js-login-form',
    function (form) {
        document.querySelector("#app").innerHTML = `<board-header></board-header>`;
    }
);
