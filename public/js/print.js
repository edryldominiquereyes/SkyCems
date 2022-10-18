function printFunction() { 
  var divContents = document.getElementById("print").innerHTML;
  var prnt = window.open('', '', 'height=800, width=800');
  prnt .document.write(divContents);
  prnt .document.close();
  prnt .print();
}