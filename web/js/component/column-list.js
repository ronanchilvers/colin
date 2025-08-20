import { component } from '/js/vendor/reef.es.min.js';
import { store } from '/js/util/store.js';

class ColumnList extends HTMLElement
{
    constructor () {
        super();
        component(
            this,
            this.template
        )
    }

    template () {
        let { columns } = store;
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

// let data = signal({
//     columns: [
//         {
//             id: "col1",
//             title: "Column 1",
//         },
//         {
//             id: "col2",
//             title: "Column 2",
//         },
//         {
//             id: "col3",
//             title: "Column 3",
//         },
//     ],
//     cards: {
//         col1: [
//             {
//                 id: "card1",
//                 title: "Card 1",
//             },
//             {
//                 id: "card2",
//                 title: "Card 3",
//             }
//         ],
//         col2: [
//             {
//                 id: "card2",
//                 title: "Card 2",
//             },
//         ],
//         col3: [
//             {
//                 id: "card3",
//                 title: "Card 3",
//             }
//         ]
//     }
// });
