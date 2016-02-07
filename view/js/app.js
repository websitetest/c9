function byId(id) {
    return document.getElementById(id);
}
function getElemAllIn(elem, q) {
    return elem.querySelectorAll(q);
}
function getElemAll(q) {
    return document.querySelectorAll(q);
}
function addClass(elem, cl) {

	if (hasClass(elem, cl)) {
		return false;
	}

	var names = elem.className.split(" ");

	for (var i = 0; i < names.length; i++) {
		if (names[i] == cl) {
			return;
		}
	}
	elem.className = elem.className + " " + cl;
}

function removeClass(elem, cl) {

	var names = elem.className.split(" ");

	for (var i = 0; i < names.length; i++) {
		if (names[i] == cl) {
			names.splice(i, 1);
		}
	}

	elem.className = names.join(" ");
}

function toggleClass(elem, cl) {

	if (hasClass(elem, cl)) {

		removeClass(elem, cl);
		return false;
	}
	addClass(elem, cl);
	return true;
}

function hasClass(elem, cl) {

	if (typeof elem.className == 'undefined') {
		return false;
	}
	var names = elem.className.split(" ");

	for (var i = 0; i < names.length; i++) {
		if (names[i] == cl) {
			return true;
		}
	}
	return false;
}

function create(tagName, attr, inHtml) {
    
    var elem = document.createElement(tagName);
    
    var aliases = {'className': ['class', 'className'], 'id': ['id']};
    
    if(attr) {
        for(var k in attr) {
            
            for(var a in aliases) {
                for(var d in aliases[a]) {
                    if(d.toLowerCase() == k.toLowerCase()) {
                        
                        elem[a] = attr[k];
                        continue;
                    }
                }
            }
            
            elem[k] = attr[k];
        }
    }
    
    if(inHtml) {
        elem.innerHTML = inHtml;
    }
    
    return elem;
}

function findParent(elem, tagName) {
    
    var p = elem;
    
    while(p.parentNode) {
        
        if(p.tagName.toLowerCase() == tagName.toLowerCase()) {
            
            return p;
        }
        p = p.parentNode;
    }
    return null;
}

var App = function() {
    
    var overlay;
    var topNav;
    var headerTop;
    var topRollout;
    var basketTable;
    var basketTableTotalRow;
    
    this.init = function() {
        
        overlay = byId('overlay');
        topNav = getElemAll('.top-nav')[0];
        headerTop = getElemAll('.top')[0];
        topRollout = getElemAll('.top-rollout')[0];
        basketTable = byId('basket-table');
        basketTableTotalRow = getElemAllIn(basketTable, '.basket-table-total')[0];
        
        var backs = getElemAll('.product-page-back');
        var forwards = getElemAll('.product-page-forward');
        
        for(var n = 0; n < backs.length; n++) {
            
            addListener(backs[n], 'click', (function() {
                return function(event) {
                    t.setLoading(true);
                };
            })(), 'backs_setLoading_true', false);
        }
        
        for(var nn = 0; nn < forwards.length; nn++) {
            
            addListener(forwards[nn], 'click', (function() {
                return function(event) {
                    t.setLoading(true);
                };
            })(), 'forwards_setLoading_true', false);
        }
        
        addListener(window, 'scroll', (function() {
            return function(event) {
                t.scrolled(event);
            };
        })(), 'forwards_setLoading_true', false);
        
        var links = getElemAll('.top-right-inner .tab-link');
        var t = this;
        
        for(var i = 0; i < links.length; i++) {
            
            addListener(links[i], 'click', (function(link, t) {
                return function(event) {
                    t.openPanel(link, event);
                };
            })(links[i], t), 'openPanel', false);
        }
        
        
        var addBtns = getElemAll('.basket-add-btn');
        for(var b = 0; b < addBtns.length; b++) {
            
             addListener(addBtns[b], 'click', (function(btn, t) {
                return function(event) {
                    t.addToShoppingBasket(btn, event);
                };
            })(addBtns[b], t), 'addToShoppingBasket', false);
        }
    };
    
    this.openPanel = function(link, event) {
        
        var lis = getElemAll('.top-right-inner li');
        for(var i = 0; i < lis.length; i++) {
            removeClass(lis[i], 'active');
        }
        
        var li = link.parentNode;
        addClass(li, 'active');
        
        var t = this;
        addListener(window, 'click', (function(t) {
            return function(event) {
                t.closePanels(event);
            };
        })(t), 'close', false);
    };
    
    this.closePanels = function(event) {
        
        var target = event.target;
        var current = target;
        while(current.parentNode) {
            
            if(hasClass(current, 'tab-link')) {
                console.log('Event target was inside .tab-link');
                return;
            }
            if(hasClass(current, 'rollout-panel')) {
                console.log('Event target was inside .rollout-panel');
                return;
            }
            current = current.parentNode;
        }
        
        var lis = getElemAll('.top-right-inner li');
        for(var i = 0; i < lis.length; i++) {
            removeClass(lis[i], 'active');
        }
    };
    
    this.addToShoppingBasket = function(btn, event) {
        
        var productId = byId('product-viewing-id').value;
        var csrf = byId('anti-csrf-input').value;
        
        var t = this;
        
        var req = new AjaxRequest(
            '/basket/add',
            'post',
            'product_id=' + productId + '&csrf=' + csrf,
            function(res) {
                
                try {
                    var data = JSON.parse(res);
                } catch(e) {
                    console.log('Exception (responseText seems to be no JSON): ' + e.message);
                }
                
                var tr = create('tr');
                var imgTd = create('td');
                var img = create('img', {'src': data.product.img_src});
                imgTd.appendChild(img);
                tr.appendChild(imgTd);
                
                var nameTd = create('td', null, data.product.name);
                tr.appendChild(nameTd);
                
                var priceTd = create('td');
                var html = '&euro;' + data.product.price_integer 
                            + '<span class="decimal-small">'
                            + data.product.price_decimals 
                            + '</span>';
                priceTd.innerHTML = html;
                tr.appendChild(priceTd);
                
                var btnTd = create('td');
                
                function echoText(str){
                    var spanEl= document.createElement('span');
                    spanEl.innerHTML= str;
                    return spanEl.firstChild.nodeValue;
                }
                
                var val = echoText('&#215;');
                
                var removeBtn = create('input', {'type': 'button', 'className': 'btn btn-white remove', 'value': val});
                addListener(removeBtn, 'click', (function(productId, btn, t) {
                    return function(event) {
                        t.removeProductFromBasket(productId, btn, event);
                    };
                })(data.product.id, removeBtn, t), 'removeProductFromBasket', false);
                
                btnTd.appendChild(removeBtn);
                tr.appendChild(btnTd);
                
                var tbody = getElemAllIn(basketTable, 'tbody')[0];
                tbody.insertBefore(tr, basketTableTotalRow);
                
                var msg = byId('added-to-basket');
                msg.innerHTML += ' ' + productId + ' ' + csrf;
                addClass(msg, 'open');
            },
            function() {
                var msg = byId('added-to-basket');
                msg.innerHTML = 'ERROR. Kon product niet toevoegen.';
                addClass(msg, 'error open');
            },
            null,
            true
        );
        
        req.send();
    };
    
    this.removeProductFromBasket = function(productId, clickedBtn, event) {
        
        var csrf = byId('basket-anti-csrf').value;
        
        var req = new AjaxRequest(
            '/basket/remove',
            'post',
            'product_id=' + productId + '&csrf=' + csrf,
            function(res) {
                
                var parent = findParent(clickedBtn, 'tr');
                
                parent.parentNode.removeChild(parent);
            },
            function() {
                alert('Kon product niet verwijderen. Er ging iets fout');
            },
            null,
            true
        );
        
        req.send();
    };
    
    this.setLoading = function(isLoading) {
        
        this.isLoading = isLoading;
        if(isLoading) {
            addClass(overlay, 'visible');
            addClass(overlay, 'fade-in');
        } else {
            removeClass(overlay, 'fade-in');
            removeClass(overlay, 'visible');
        }
    };
    
    this.scrolled = function() {
        
        var scrollY = window.pageYOffset || document.documentElement.scrollTop;
        
        console.log(headerTop.offsetHeight);
        if(scrollY > headerTop.offsetHeight) {
            headerTop.style.marginBottom = topNav.offsetHeight + 'px';
            addClass(topNav, 'sticky-top');
        } else {
            removeClass(topNav, 'sticky-top');
            headerTop.style.marginBottom = '0px';
        }
    };
    
    this.topNavRollout = function() {
        
        addClass(topRollout, 'open');
        var cards = getElemAll('.top-rollout-card');
        
        for(var c = 0; c < cards.length; c++) {
            removeClass(cards[c], 'visible');
        }
        addClass(cards[0], 'visible');
    };
    
    this.init();
};

var Basket = function() {
    
    
};

var RangeSlider = function(id) {
    
    this.id = id;
    var slider;
    var handles;
    var dragStartX;
    var dragStartY;
    var handleStartX;
    var handleStartY;
    var handleDragging;
    var fillers;
    
    this.init = function() {
        
        slider = document.getElementById(id);
        handles = getElemAllIn(slider, '.range-handle');
        fillers = getElemAllIn(slider, '.range-fill');
        var t = this;
        
        for(var i = 0; i < handles.length; i++) {
            
            /*handles[i].addEventListener('mousedown', (function(h, t) {
                
                return function(event) {
                    t.startHandleDrag(h, event);
                };
            })(handles[i], t), false);
            */
            
            addListener(handles[i], 'mousedown', (function(h, t) {
                return function(event) {
                    t.startHandleDrag(h, event);
                };
            })(handles[i], t), 'startHandleDrag', false);
            
            addListener(slider, 'mousedown', (function(s, t) {
                return function(event) {
                    t.sliderClick(s, event);
                };
            })(slider, t), 'sliderClick', false);
        }
        
        this.updateFiller();
    };
    
    this.startHandleDrag = function(handle, event) {
        
        pauseEvent(event);
        
        dragStartX = event.pageX;
        dragStartY = event.pageY;
        handleStartX = handle.offsetLeft;
        handleStartY = handle.offsetTop;
        handleDragging = handle;
        
        var t = this;
        
        addListener(window, 'mousemove', (function(handle) {
            return function(event) {
                t.moveHandle(handle, event);
            };
        })(handle), 'moveHandle', false);
        
        addListener(window, 'mouseup', (function(handle) {
            return function(event) {
                t.stopHandleDrag(handle, event);
            };
        })(handle), 'stopHandleDrag', false);
        
        addListener(window, 'click', (function(handle) {
            return function(event) {
                t.stopHandleDrag(handle, event);
            };
        })(handle), 'stopHandleDrag_click', false);
    };
    
    this.moveHandle = function(handle, event) {
        
        pauseEvent(event);
        
        var sliderWidth = slider.offsetWidth;
        var deltaX = event.pageX - dragStartX;
        
        var nx = parseInt(handleStartX) + parseInt(deltaX);
        
        if(nx <= 0 || nx >= sliderWidth) {
            return;
        }
        handle.style.left = nx + 'px';
        
        this.updateFiller();
        
    };
    
    this.stopHandleDrag = function(handle, event) {
        removeListener(window, 'mousemove', 'moveHandle', false);
    };
    
    this.sliderClick = function(slider, event) {
        
        console.log(handles[0].offsetLeft);
        
        var sliderX = slider.offsetLeft;
        var clickX = event.pageX;
        var deltaX = clickX - sliderX;
        
        var closest = handles[0];
        for(var i = 0; i < handles.length; i++) {
            if(Math.abs(handles[i].offsetLeft - deltaX) <= Math.abs(closest.offsetLeft - deltaX)) {
                closest = handles[i];
            }
        }
        
        closest.style.left = deltaX - (closest.offsetWidth / 2) + 'px';
        
        this.updateFiller();
    };
    
    this.updateFiller = function() {
        
        var stretch = {'starts': [], 'ends': []};
        for(var i = 0; i < handles.length; i++) {
            if(i < handles.length - 1) {
                stretch.starts.push(handles[i].offsetLeft);
            }
            if(i > 0) {
                stretch.ends.push(handles[i].offsetLeft - handles[i - 1].offsetLeft);
            }
        }
        if(handles.length == 1) {
            stretch.starts = [0];
            stretch.ends = [handles[0].offsetLeft];
        }
        
        for(var f = 0; f < fillers.length; f++) {
            
            fillers[f].style.left = stretch.starts[f] + 'px';
            fillers[f].style.width = stretch.ends[f] + 'px';
        }
    };
    
    this.init();
};

var handlers = [];
function addListener(elem, type, handler, handlerName, capture) {
    handlers.push({'handlerName': handlerName, 'func': handler});
    elem.addEventListener(type, handler, capture);
}
function removeListener(elem, type, handlerName, capture) {
    
    for(var i = 0; i < handlers.length; i++) {
        
        if(handlers[i].handlerName == handlerName) {
            elem.removeEventListener(type, handlers[i].func, capture);
        }
    }
}
function pauseEvent(e){
    if(e.stopPropagation) e.stopPropagation();
    if(e.preventDefault) e.preventDefault();
    e.cancelBubble=true;
    e.returnValue=false;
    return false;
}


var NewsletterForm = function() {
    
}

var TopRolloutPanel = function() {
    
};

var ImageViewer = function(id) {
    
    this.id = id;
    var container;
    var viewPort;
    var viewPortImage;
    var imageList;
    var imageListItems;
    
    this.init = function() {
        
        container = byId(this.id);
        viewPort = getElemAllIn(container, '.product-image-viewport')[0];
        viewPortImage = getElemAllIn(viewPort, 'img')[0];
        imageList = getElemAllIn(container, '.image-list')[0];
        imageListItems = getElemAllIn(imageList, 'li');
        
        var t = this;
        
        for(var i = 0; i < imageListItems.length; i++) {
            
            addListener(imageListItems[i], 'click', (function(item, ind) {
                return function(event) {
                    t.imageListItemClick(item, ind, event);
                };
            })(imageListItems[i], i), 'imageListItemClick', false);
        }
        
        addListener(viewPort, 'mousemove', (function() {
            return function(event) {
                t.viewPortMousemove(event);
            };
        })(), 'viewPortMousemove', false);
    };
    
    this.init();
    
    this.imageListItemClick = function(item, index, event) {
        
        for(var i = 0; i < imageListItems.length; i++) {
            removeClass(imageListItems[i], 'active');
        }
        addClass(item, 'active');
        
        viewPortImage.src = '/view/img/10-percent-discount.jpg';
        viewPortImage.width = 600;
        viewPortImage.height = 600;
    };
    
    this.viewPortMousemove = function(event) {
        
        viewPort.style.overflow = 'hidden';
        
        var insideX = event.pageX - viewPort.offsetLeft - 10;
        var insideY = event.pageY - viewPort.offsetTop - 10;
        var w = viewPort.offsetWidth - 10;
        var h = viewPort.offsetHeight - 10;
        var imgWidth = viewPortImage.offsetWidth;
        var imgHeight = viewPortImage.offsetHeight;
        
        var deltaWidth = imgWidth - w;
        var deltaHeight = imgHeight - h;
        
        var left = 0;
        var top = 0;
        
        if(deltaWidth > 0) {
            left = -insideX * (deltaWidth / w);
            viewPortImage.style.left = left + 'px';
            console.log('mouseover ' + left);
        }
        
        if(deltaHeight > 0) {
            top = -insideY * (deltaHeight / h);
            viewPortImage.style.top = top + 'px';
            console.log('mouseover ' + top);
        }
        
    };
};