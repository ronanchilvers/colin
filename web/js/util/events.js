function watch(watcher, watched, eventName, type = "childList") {
    const observer = new MutationObserver((mutations, observer) => {
        for (const mutation of mutations) {
            if (mutation.type == type) {
                watcher.dispatchEvent(
                    new CustomEvent(
                        eventName,
                        {
                            detail: {
                                watcher: watcher,
                                watched: watched,
                            }
                        }
                    )
                );
            }
        }
    });
    observer.observe(watched, {
        childList: true,
    });
    return observer;
}

function unwatch(watcher) {
    if (watcher) {
        watcher.disconnect();
    }
}

export { watch, unwatch };
