document.getElementById("toolsBSYear").addEventListener("input", convertBStoAD);
document.getElementById("toolsBSMonth").addEventListener("input", convertBStoAD);
document.getElementById("toolsBSDay").addEventListener("input", convertBStoAD);

document.getElementById("toolsADYear").addEventListener("input", convertADtoBS);
document.getElementById("toolsADMonth").addEventListener("input", convertADtoBS);
document.getElementById("toolsADDay").addEventListener("input", convertADtoBS);

function convertBStoAD() {
  const bsYear = parseInt(document.getElementById("toolsBSYear").value);
  const bsMonth = parseInt(document.getElementById("toolsBSMonth").value);
  const bsDay = parseInt(document.getElementById("toolsBSDay").value);

  if (bsYear && bsMonth && bsDay) {
    const nepaliDate = new NepaliDate(bsYear, bsMonth - 1, bsDay);
    const adDate = nepaliDate.getAD();

    document.getElementById("toolsADYear").value = adDate.year;
    document.getElementById("toolsADMonth").value = adDate.month + 1;
    document.getElementById("toolsADDay").value = adDate.date;
  }
}

function convertADtoBS() {
  const adYear = parseInt(document.getElementById("toolsADYear").value);
  const adMonth = parseInt(document.getElementById("toolsADMonth").value);
  const adDay = parseInt(document.getElementById("toolsADDay").value);

  if (adYear && adMonth && adDay) {
    const adJsDate = new Date(adYear, adMonth - 1, adDay);
    const nepaliDate = NepaliDate.fromAD(adJsDate);

    const bsDate = nepaliDate.getBS();
    document.getElementById("toolsBSYear").value = bsDate.year;
    document.getElementById("toolsBSMonth").value = bsDate.month + 1;
    document.getElementById("toolsBSDay").value = bsDate.date;
  }
}
