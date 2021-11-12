let sklep = {
  nazwa: "Pod nosem",
  godzina_otwarcia: 10,
  godzina_zamkniecia: 23,
  produkty: [{
      nazwa: "Pomidor",
      cena_brutto: 5.99,
      kod_produktu: 5486636,
      pochodzenie: "Polska",
      stawka_vat: 5,
      cenowka: { nazwa: "Pomidor luz", cena: 5.99}
  },
  {
      nazwa: "Banan",
      cena_brutto: 3.99,
      kod_produktu: 45645,
      pochodzenie: "Polska",
      stawka_vat: 5,
      cenowka: { nazwa: "Banan", cena: 3.99}
  },
  {
      nazwa: "Bułka",
      cena_brutto: 0.29,
      kod_produktu: 45645,
      pochodzenie: "Polska",
      stawka_vat: 5,
      cenowka: { nazwa: "Kajzerka", cena: 0.29}
  }]
};

let produkt = {
  nazwa: "Pomidor",
  cena_brutto: 5.99,
  kod_produktu: 5486636,
  pochodzenie: "Polska",
  stawka_vat: 5,
  cenowka: { nazwa: "Pomidor luz", cena: 5.99}
};


//PLIK .TXT BO TEAMS BLOKUJE PLIKI JS :))

function check(kody){
  for(let i = 0; i < kody.length; i++) {
    if(kody.indexOf(kody[i]) != i)
      return true;
  }
  return false;
}

function a(sklep){
  console.log("=========================================");
  for(let i = 0; i < sklep.produkty.length; i++){
    console.log("Nazwa produktu: " + sklep.produkty[i].nazwa);
    console.log("Cena brutto: " + sklep.produkty[i].cena_brutto);
    console.log("Cena netto: " + (sklep.produkty[i].cena_brutto / (1 + (sklep.produkty[i].stawka_vat / 100)) ) );
    if(sklep.produkty[i].cena_brutto != sklep.produkty[i].cenowka.cena)
      console.log("Zgodnosc ceny: nie");
    else
      console.log("Zgodnosc ceny: tak");
    console.log("=========================================");
  }

  let kody = [];
  for(let i = 0; i < sklep.produkty.length; i++){
    kody[i] = sklep.produkty[i].kod_produktu;
  }
  
  if(check(kody))
    console.log("Kody nie sa unikatowe");
  else
    console.log("Kody sa unikatowe");
}

a(sklep);
