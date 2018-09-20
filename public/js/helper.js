if (!Array.from) {
    Array.from = (function () {
        var toStr = Object.prototype.toString;
        var isCallable = function (fn) {
            return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
        };
        var toInteger = function (value) {
            var number = Number(value);
            if (isNaN(number)) {
                return 0;
            }
            if (number === 0 || !isFinite(number)) {
                return number;
            }
            return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
        };
        var maxSafeInteger = Math.pow(2, 53) - 1;
        var toLength = function (value) {
            var len = toInteger(value);
            return Math.min(Math.max(len, 0), maxSafeInteger);
        };

        // The length property of the from method is 1.
        return function from(arrayLike/*, mapFn, thisArg */) {
            // 1. Let C be the this value.
            var C = this;
            // 2. Let items be ToObject(arrayLike).
            var items = Object(arrayLike);
            // 3. ReturnIfAbrupt(items).
            if (arrayLike == null) {
                throw new TypeError("Array.from requires an array-like object - not null or undefined");
            }

            // 4. If mapfn is undefined, then let mapping be false.
            var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
            var T;
            if (typeof mapFn !== 'undefined') {
                // 5. else
                // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
                if (!isCallable(mapFn)) {
                    throw new TypeError('Array.from: when provided, the second argument must be a function');
                }

                // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
                if (arguments.length > 2) {
                    T = arguments[2];
                }
            }

            // 10. Let lenValue be Get(items, "length").
            // 11. Let len be ToLength(lenValue).
            var len = toLength(items.length);

            // 13. If IsConstructor(C) is true, then
            // 13. a. Let A be the result of calling the [[Construct]] internal method of C with an argument list containing the single item len.
            // 14. a. Else, Let A be ArrayCreate(len).
            var A = isCallable(C) ? Object(new C(len)) : new Array(len);

            // 16. Let k be 0.
            var k = 0;
            // 17. Repeat, while k < len… (also steps a - h)
            var kValue;
            while (k < len) {
                kValue = items[k];
                if (mapFn) {
                    A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
                } else {
                    A[k] = kValue;
                }
                k += 1;
            }
            // 18. Let putStatus be Put(A, "length", len, true).
            A.length = len;
            // 20. Return A.
            return A;
        };
    }());
}

if (!Array.prototype.findIndex) {
  Array.prototype.findIndex = function(predicate) {
    if (this == null) {
      throw new TypeError('Array.prototype.findIndex called on null or undefined');
    }
    if (typeof predicate !== 'function') {
      throw new TypeError('predicate must be a function');
    }
    var list = Object(this);
    var length = list.length >>> 0;
    var thisArg = arguments[1];
    var value;

    for (var i = 0; i < length; i++) {
      value = list[i];
      if (predicate.call(thisArg, value, i, list)) {
        return i;
      }
    }
    return -1;
  };
}

function clearNode(node) {
    if (!node) {
        return false;
    }
    while (node.firstChild) {
        node.removeChild(node.firstChild);
    }
}

function el (tagName, attributes, children) {
    var element = document.createElement(tagName);
    if (typeof attributes === 'object') {
        Object.keys(attributes).forEach( function (i) {
            element.setAttribute(i, attributes[i]);
        });
    }
    if (typeof children === 'string') {
        element.textContent = children;
    } else if (children instanceof Array) {
        children.forEach( function (child) {
            if (typeof child === 'string') {
                element.appendChild(document.createTextNode(child));
            } else {
                element.appendChild(child);
            }

        });
    }
    return element;
}

function createEl(type, className, id) {
    var el = document.createElement(type);
    if (className) {
        el.className = className;
    }
    if (id) {
        el.id = id;
    }
    return el;
}

function createInput(name, className, id, type) {
    var input = createEl('input', className, id);
    if (name) {
        input.name = name;
    }
    if (type) {
        input.setAttribute('type', type);
    }
    return input;
}

function createPseudoInput(className, id, value) {
    var p = createEl('p', className, id);
    if (value !== 'undefined') {
        p.innerText = value;
    }
    return p;
}

function createField(labelText, node, className, classNameLabel) {
    if (!className) {
        className = 'form-group';
    }
    var divGroup = createEl('div', className);
    var label = createEl('label');
    label.innerText = labelText;
    if (classNameLabel) {
        label.className = classNameLabel;
    }
    divGroup.appendChild(label);
    divGroup.appendChild(node);
    return divGroup;
}

function createFieldHorizontal(labelText, node, className) {
    if (!className) {
        className = 'form-group';
    }
    var divGroup = createEl('div', className);

    var divRow = createEl('div', 'row');

    var label = createEl('label');
    var labelBlock = createEl('div', 'col-xs-12 col-md-3');
    var inputBlock = createEl('div', 'col-xs-12 col-md-9');
    label.innerText = labelText;

    labelBlock.appendChild(label);
    divRow.appendChild(labelBlock);


    inputBlock.appendChild(node);
    divRow.appendChild(inputBlock);

    divGroup.appendChild(divRow);
    return divGroup;
}

function sendData(url, data, func, csrfToken) {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener('load', function (e) {
        if (func) {
            func(xhr.response);
        }
    });
    xhr.addEventListener('error', function (e) {
        console.log("Ошибка " + e.target.status);
    });
    var method = "POST";
    if (!data) {
        method = "GET";
    }
    xhr.open(method, url);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    if (csrfToken) {
        xhr.setRequestHeader("X-CSRF-Token", csrfToken);
    }
    xhr.send(data);
}


function sendDataN(url, data, func, csrfToken) {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener('load', function (e) {
        if (func) {
            func(xhr.response);
        }
    });
    xhr.addEventListener('error', function (e) {
        console.log("Ошибка " + e.target.status);
    });
    var method = "POST";
    if (!data) {
        method = "GET";
    }
    xhr.open(method, url);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    if (method == 'POST') {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        if (typeof data == 'object') {
            data = stringifyObject(data);
        }
    }
    if (csrfToken) {
        xhr.setRequestHeader("X-CSRF-Token", csrfToken);
    }
    xhr.send(data);
}

function stringifyObject(obj, prefix) {

    var str = [], p;
    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p,
                v = obj[p];
            str.push((v !== null && typeof v === "object") ?
                stringifyObject(v, k) :
                encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
}


function showWaiting(parent) {
    if (!parent) {
        return false;
    }
    var existWaiting = parent.querySelector('.waiting-wrapper');
    if (existWaiting) {
        return false;
    }
    var wrapperWaiting = createEl('div', 'waiting-wrapper');
    var waitingBlock = createEl('div', 'waiting-block');
    var waitingIcon = createEl('div', 'waiting-icon');
    var waitingText = createEl('div', 'waiting-text');
    waitingText.innerText = 'Подождите...';
    waitingBlock.appendChild(waitingIcon);
    waitingBlock.appendChild(waitingText);
    wrapperWaiting.appendChild(waitingBlock);
    parent.appendChild(wrapperWaiting);
}

function hideWaiting(parent) {
    if (!parent) {
        return false;
    }
    var waiting = parent.querySelector('.waiting-wrapper');
    if (waiting) {
        parent.removeChild(waiting);
    }
}

function showLoading(parent) {
    if (!parent) {
        return false;
    }
    parent.classList.add('loading');
}

function hideLoading(parent) {
    if (!parent) {
        return false;
    }
    parent.classList.remove('loading');
}

function toggleWaiting(node) {
    if (node.classList.contains('waiting')) {
        node.classList.remove('waiting');
    } else {
        node.classList.add('waiting');
    }
}

function addElementsSelect(node, array, func, selected) {
    if (!array) {
        return false;
    }
    var index = 0;
    array.forEach(function (value) {
        if (func) {
            func(value, index);
        }
        var option = createEl('option');
        option.value = value.id;
        option.innerText = value.name;
        if (selected === value.id) {
            option.setAttribute('selected', '');
        }
        node.appendChild(option);
        index++;
    });
}

function getParameterByName(name, url) {
    if (!url)
        url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function showBlock(node) {
    if (!node) {
        return false;
    }
    if (isHidden(node)) {
        node.style.display = "block";
    } else {
        node.style.display = "none";
    }
}

function isHidden(el) {
    var style = window.getComputedStyle(el);
    return (style.display === 'none');
}

function getParentByClassname(object, className) {
    if (!object) {
        return false;
    }
    var currentLevel = object;
    while (currentLevel.parentNode) {
        try {
            if (currentLevel.parentNode.classList.contains(className)) {
                return currentLevel.parentNode;
            }
            currentLevel = currentLevel.parentNode;
        } catch (error) {
            return false;
        }
    }
    return false;
}

function insertAfter(elem, afterElem) {
    if (!elem || !afterElem) {
        return false;
    }
    var parent = afterElem.parentNode;
    var nextSibling = afterElem.nextSibling;
    if (!nextSibling) {
        parent.appendChild(elem);
    } else {
        parent.insertBefore(elem, nextSibling);
    }
}

function formatDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    return formatNum(day) + '.' + formatNum(month) + '.' + year;
}

function formatNum(number, count) {
    if (!count) {
        count = 2;
    }
    var strNumber = number.toString();
    if (strNumber.length < count) {
        strNumber = "0" + strNumber;
    }
    return strNumber;
}

function showMessage(message, isError) {
    if (typeof isError === 'undefined') {
        isError = false;
    }
    //console.log(isError, typeof isError);
    var messageBlock = createEl('div', 'popup-message');
    var id = 'popup' + getRandomArbitrary(1, 9999);
    messageBlock.setAttribute('id', id);
    messageBlock.innerText = message;
    if (isError) {
        messageBlock.classList.add('error');
    }
    document.body.appendChild(messageBlock);
    setTimeout(function () {
        document.body.removeChild(messageBlock);
    }, 3000);
}

function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}

function drawPopup(x, y, fragment, parent) {
    var popupDialog = document.querySelector('.small-popup-dialog');
    if (popupDialog) {
        var parent = popupDialog.parentNode;
        parent.removeChild(popupDialog);
    }
    popupDialog = createEl('div', 'small-popup-dialog');
    var closeButton = createEl('button', 'btn btn-close');
    closeButton.innerText = "✖";
    closeButton.dataset.action = "close";
    popupDialog.appendChild(closeButton);
    popupDialog.appendChild(fragment);
    popupDialog.style = "top:" + y + "px; left:" + x + "px;";
    if (parent) {
        parent.appendChild(popupDialog);
    } else {
        document.body.appendChild(popupDialog);
    }
}

function hidePopup() {
    var popupDialog = document.querySelector('.small-popup-dialog');
    if (popupDialog) {
        var parent = popupDialog.parentNode;
        parent.removeChild(popupDialog);
    }
}

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}