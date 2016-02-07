function byId(id) {
    return document.getElementById(id);
}
function getElem(q) {
    return document.querySelector(q);
}
function getElemAll(q) {
    return document.querySelectorAll(q);
}
function getElemAllIn(elem, q) {
    return elem.querySelectorAll(q);
}
function inArray(needle, haystack) {
    
    for(var i in haystack) {
        if(haystack[i] == needle) {
            return true;
        }
    }
    return false;
}
function addClass(elem, cl) {
    
    var cn = elem.className;
    var names = cn.split(/\s/);
    
    if(inArray(cl, names)) {
        return;
    }
    
    elem.className += ' ' + cl;
}
function hasClass(elem, cl) {
    
    var cn = elem.className;
    var names = cn.split(/\s/);
    
    if(inArray(cl, names)) {
        return true;
    }
    return false;
}
function removeClass(elem, cl) {
    
    var cn = elem.className;
    var names = cn.split(/\s/);
    
    if( ! inArray(cl, names)) {
        return false;
    }
    
    for(var i = 0; i < names.length; i++) {
        if(names[i] == cl) {
            names[i] = '';
        }
    }
    
    elem.className = names.join(' ');
}
function toggleClass(elem, cl) {
    
    if(hasClass(elem, cl)) {
        removeClass(elem, cl);
    } else {
        addClass(elem, cl);
    }
}
function findParent(elem, parentTag) {
    
    var p = elem;
    while(p.parentNode) {
        
        if(p.tagName.toUpperCase() == parentTag.toUpperCase()) {
            return p;
        }
        p = p.parentNode;
    }
    return null;
}

