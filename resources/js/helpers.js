export function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        }, wait);
        if (immediate && !timeout) func.apply(context, args);
    };
}

// export function index(node) {
//     var children = node.parentNode.childNodes;
//     var num = 0;
//     for (var i=0; i<children.length; i++) {
//         if (children[i]==node) return num;
//         if (children[i].nodeType==1) num++;
//     }
//     return -1;
// }