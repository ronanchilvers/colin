import { listenFor } from '/js/util/listenFor.js';

class CustomElement extends HTMLElement
{
    static observedAttributes = [
        'id',
    ];

    constructor() {
        super();
        this._id = null;
        this.observers = [];
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === "id") {
            this._id = newValue;
        }
    }

    connectedCallback() {
        this.setup();
    }

    disconnectedCallback() {
        this.tearDown();
    }

    setup() {
        console.log('CustomElement - setup');
    }

    tearDown() {
        this.observers.forEach((observer) => {
            observer.disconnect();
        });
    }

    observe(element, eventName, type = "childList") {
        const observer = new MutationObserver((mutations, observer) => {
            for (const mutation of mutations) {
                if (mutation.type == type) {
                    this.emit(
                        eventName,
                        { observed: element }
                    );
                }
            }
        });
        observer.observe(element, {
            childList: true,
        });
        this.observers.push(observer);

        return observer;
    }

    emit(eventName, detail, options) {
        options = { ...{ bubbles: true, detail: detail }, ...options };
        this.dispatchEvent(
            new CustomEvent(
                eventName,
                options
            )
        );
    }

    listen(element, eventName, handler, selector = null) {
        listenFor(element, eventName, handler, selector);
    }

    id() {
        return this._id;
    }
}

export default CustomElement;
