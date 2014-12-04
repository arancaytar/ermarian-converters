encode = function(x) {
  var output = [];
  x = x.toUpperCase().trim();
  for (i in x) {
    if (alphabet[x[i]]) output.push(alphabet[x[i]]);
    else return 'Error: Bad character "' + x[i] + '" at #' + i + '.';
  }
  return output.join(' ');
}

decode = function(x) {
  var output = [];
  x = x.trim().split(/\s+/);
  for (i in x) {
    if (alphabet_rev[x[i]]) output.push(alphabet_rev[x[i]]);
    else return 'Error: Bad code "' + x[i] + '" at #' + i + '.';
  }
  return output.join('');
}

code = function(x) {
  x = x.toUpperCase().trim();
  if (!x) return "";
  return x.match(/[^\s.\/-]/) ? encode(x) : decode(x);
}

alphabet = {
  'A': '.-',
  'B': '-...',
  'C': '-.-.',
  'D': '-..',
  'E': '.',
  'F': '..-.',
  'G': '--.',
  'H': '....',
  'I': '..',
  'J': '.---',
  'K': '-.-',
  'L': '.-..',
  'M': '--',
  'N': '-.',
  'O': '---',
  'P': '.--.',
  'Q': '--.-',
  'R': '.-.',
  'S': '...',
  'T': '-',
  'U': '..-',
  'V': '...-',
  'W': '.--',
  'X': '-..-',
  'Y': '-.--',
  'Z': '--..',
  '0': '-----',
  '1': '.----',
  '2': '..---',
  '3': '...--',
  '4': '....-',
  '5': '.....',
  '6': '-....',
  '7': '--...',
  '8': '---..',
  '9': '----.',
  '.': '.-.-.-',
  ',': '--..--',
  '?': '..--..',
  ' ': '/',
  '-': '-....-',
  ')': '-.--.-'
};

alphabet_rev = {};
for (x in alphabet) alphabet_rev[alphabet[x]] = x;

(function($) {
  $(document).ready(function() {
    var input = $('#input');
    var output = $('#output');
    var update = function() {
      var text = input.val();
      output.text(code(text));
    }
    input.on('keypress change keyup', function() {
      update();
    });
    update();
    $('#submit').hide();
  });
})($);
