function listenFor(element, eventName, handler, selector = null) {
    element.addEventListener(eventName, (e) => {
        if (selector && !e.target.matches(selector)) return;
        handler(e);
    });
}

export { listenFor };
