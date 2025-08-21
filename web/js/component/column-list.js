import { signal, component } from '/js/vendor/reef.es.min.js';

class ColumnList extends HTMLElement
{
    signal = signal({
        columns: []
    });
    constructor () {
        super();
        component(
            this,
            this.template.bind(this)
        )
    }

    connectedCallback () {
        this.addEventListener('submit', (e) => {
            if (e.target.matches('.js-add-column-form')) {
                e.preventDefault();
                const input = e.target.querySelector('input');
                const title = input.value.trim();
                if (title) {
                    window.board.createColumn(title);
                    input.value = '';
                }
            }
        });
    }

    template () {
        let { columns } = this.signal;
        let html = "";
        columns.forEach((column) => {
            let {id, title} = column;
            html += `<column-element id="${id}"></column-element>`;
        });

        return `
        <div id="column_container" class="board">
            ${html}
            <div class="column add-column">
                <form class="js-add-column-form column__header">
                    <input placeholder="Add a column..."/>
                </form>
            </div>
        </div>
        `;
    }
}

customElements.define(
    'column-list',
    ColumnList
);
