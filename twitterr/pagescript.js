


/** @jsx h */
'use strict'; function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
if (typeof h == 'undefined') {
  const { h, Component, render } = preact;
}

window.debounce = window.debounce || function (callback, delay) {
  var timer;
  return function () {
    var args = arguments;
    var context = this;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, delay);
  };
};

window.onload = function () {
  TwitterEditor.init();
};

var TwitterEditor = {
  editor: null,
  marker: null,
  characterCount: null,
  isValid: false,

  // Add codeMirror as editor
  init: function () {
    TwitterEditor.characterCount = render(h(CharacterCounter, null), document.body.querySelector(".js-character-counter"))._component;

    // Init codeMirror
    var textarea = document.body.querySelector(".rich-editor"),
      editor = CodeMirror.fromTextArea(textarea, {
        lineNumbers: false,
        scrollbarStyle: "null",
        lineWrapping: true
      });

    TwitterEditor.editor = editor;

    // Handle letter count
    editor.on("change", debounce(TwitterEditor.handleChange, 150));
    if (typeof twemoji != "undefined") {
      editor.on("inputRead", function (cm, e) {
        if (e.origin == "paste") {
          this.formatPastedContent(cm, e);
        }
      }.bind(this));
    }

    // Handle link highlighting
    TwitterEditor.initMode();
    editor.setOption("mode", "twitter");

    // Add emojiPicker
    if (window.EmojiModal) {
      TwitterEditor.addEmojiModal();
    }
  },

  // Replace raw emoji with image
  formatPastedContent: function (cm, e) {
    var line = e.from.line,
      ch = e.from.ch;

    for (var i = 0; i < e.text.length; i++) {
      twemoji.replace(e.text[i], function (char, capture, pos) {

        // Get emoji img
        var url;
        twemoji.parse(char, {
          "size": 72,
          "className": "cm-emoji",
          "callback": function (icon, options) {
            url = ''.concat(options.base, options.size, '/', icon, options.ext);
          }
        });


        var node = document.createElement("img");
        node.className = "cm-emoji";
        node.src = url;

        // Display img instead of char
        cm.markText(
          { line: line, ch: ch + pos },
          { line: line, ch: ch + pos + char.length },
          { replacedWith: node, clearWhenEmpty: false });

      });

      // Next paragraph: new line
      line++;
      ch = 0;
    }
  },

  addEmojiModal: function () {
    EmojiModal.addEmoji = this.addEmoji.bind(this);
    EmojiModal.init();
  },

  addEmoji: function (char, imgUrl) {
    var unicode = String.fromCodePoint.apply(
      null, char.split('-').map(c => parseInt("0x" + c)));


    // Emoji value for copy
    var cm = TwitterEditor.editor;
    cm.replaceSelection(unicode, "around");

    // Displayed emoji
    var node;
    if (imgUrl) {
      node = document.createElement("img");
      node.className = "cm-emoji";
      node.src = imgUrl;
    } else {
      node = document.createElement("span");
      node.innerHTML = unicode;
    }

    var from = cm.getCursor("from"),
      to = cm.getCursor("to"),
      mark = cm.markText(from, to, {
        replacedWith: node,
        clearWhenEmpty: false
      });

    cm.focus();
    cm.setCursor(to);
    cm.refresh();
  },

  // Add custom highlight
  // https://codemirror.net/demo/simplemode.html
  initMode: function () {
    CodeMirror.defineMode("twitter", function () {
      var TOKENS = [
        { regex: /https?:\/\/[^ \n]+[^ \n.,;:?!&'"’”)}\]]/, token: "link" },
        { regex: /@\w+/, token: "link" }, // mention
        { regex: /#\w+/, token: "link" } // hashtag
      ];

      return {
        token: function (stream) {
          for (var i = 0; i < TOKENS.length; i++) {
            var rule = TOKENS[i],
              matches = stream.match(rule.regex);
            if (matches) {
              return rule.token;
            }
          }
          stream.next();
          return null;
        }
      };

    });
  },

  // Change letter count
  handleChange: function (stream) {
    var lineNo = 0,
      ttchars = 0,
      exceed = false;

    // Loop lines
    stream.doc.iter(function (line) {
      if (lineNo) {
        ttchars++; // count return carriage
      }

      // Normalize text with Normalization Form C (NFC)
      // https://developer.twitter.com/en/docs/basics/counting-characters
      var text = line.text.normalize(),
        nchars = TwitterEditor.weight(text);

      // Because links are replaced with t.co links, we only count 22 (http) or 23 (https) characters
      // https://www.dougv.com/2015/09/counting-the-number-of-characters-in-a-tweet-via-net/
      var links = text.match(/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
      if (links) {
        for (var i = 0; i < links.length; i++) {
          var olength = links[i].length,
            rlength = links[i].substr(0, 5) == "https" ? 23 : 22;
          nchars += rlength - olength;
        }
      }

      // Check if we exceed the maxlength
      if (ttchars + nchars > 280 && !exceed) {
        exceed = { line: lineNo, ch: 280 - ttchars };
      }
      ttchars += nchars;
      lineNo++;
    });

    // Highlight >= 280 chars
    if (TwitterEditor.marker) {
      TwitterEditor.marker.clear();
    }
    if (exceed) {
      TwitterEditor.marker = stream.doc.markText(exceed, { line: lineNo }, { className: 'em' });
    }

    // Display chars counter
    TwitterEditor.characterCount.setCount(ttchars);

    // Enable or disabled preview
    var isValid = ttchars > 0 && ttchars <= 280;
    if (TwitterEditor.isValid != isValid) {
      TwitterEditor.setValid(isValid);
    }
  },

  // Enable or disable preview
  setValid: function (isValid) {
    TwitterEditor.isValid = isValid;
  },

  // Count twitter text weight
  // https://developer.twitter.com/en/docs/developer-utilities/twitter-text.html
  weight: function (str) {
    var s = 0;
    for (var char of str) {
      var code = char.codePointAt(0);

      if (code <= 4351 ||
        code >= 8192 && code <= 8205 ||
        code >= 8208 && code <= 8223 ||
        code >= 8242 && code <= 8247) {
        s++;
      } else {
        s += 2;
      }
    }
    return s;
  }
};


// Handles the character counter of the editor
class CharacterCounter extends Component {


  constructor() {
    super(); _defineProperty(this, "state", { nbChars: 0, nbMax: 280 }); _defineProperty(this, "setCount",



      nbChars => {
        this.setState({ nbChars: nbChars });
      }); this.setCount = this.setCount.bind(this);
  }

  render({ }, { nbChars, nbMax }) {
    var warn = nbChars + 20 >= nbMax,
      circ = 50.2655; // circonférence du cercle = 2*PI*r;
    return (
      h("div", { title: nbChars + "/280" },
        h("div", { class: "js-countdown-counter tweet-counter" + (nbChars > nbMax ? " is-maxReached" : "") },
          warn ? nbMax - nbChars : ""),

        h("svg", { class: "RadialCounter js-radial-counter", height: "20", width: "20" },
          h("circle", { class: "RadialCounter-progressUnderlay", cx: "50%", cy: "50%", r: "8", fill: "none", "stroke-width": "1" }),
          h("circle", {
            class: "js-progress-circle RadialCounter--" + (nbChars >= nbMax ? "danger" : warn ? "warn" : "safe"), cx: "50%", cy: "50%", r: "8", fill: "none", "stroke-width": "2", style: {
              "stroke-dashoffset": nbChars >= nbMax ? circ : (circ - circ * nbChars / nbMax).toPrecision(4),
              "stroke-dasharray": circ
            }
          }))));




  }
}

