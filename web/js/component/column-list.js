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
        </div>
        `;
    }
}

customElements.define(
    'column-list',
    ColumnList
);
