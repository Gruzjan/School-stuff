//1
let liczba_lekcji = 1; 
let dlugosc_przerwy = 1;

if((liczba_lekcji > 4 && dlugosc_przerwy < 6) || liczba_lekcji > 7)
    console.log("Z1: :(");
else
    console.log("Z1: :)");

//2
var cisnienie = 1000;
var cisnienia = {};
cisnienia[999] = {probability: 66};
cisnienia[1000] = {probability: 64};
cisnienia[1001] = {probability: 61};
cisnienia[1003] = {probability: 63};
cisnienia[1004] = {probability: 50};
cisnienia[1005] = {probability: 52};
cisnienia[1006] = {probability: 48};
cisnienia[1008] = {probability: 48};
cisnienia[1009] = {probability: 47};
cisnienia[1010] = {probability: 49};

if(cisnienie in cisnienia)
    console.log("Z2: " + cisnienia[cisnienie].probability);
else
    console.log("Z2: Brak danych");

//3 a
let x = [2, 4, 6, 10, 12];
let y = [2, 5, 5, 8, 9];
let wejscie = 3, h; 
//let nX, nY;
if(wejscie < x[0] || wejscie > x[x.length])
    console.log("Poza zakresem");
else if(x.includes(wejscie))
    console.log("Z3: [" + wejscie + "," + y[x.indexOf(wejscie)] + "]");
else{
    for(let i = 0; i < x.length; i++){
        if(wejscie < x[i]){
            h = i;
            i = x.length + 1;
        }
    }
    console.log("Z3: [" + wejscie + "," + y[h-1] + "]");

    //B jesli za aproksymacje mozemy uznac srednia wspolrzednych dwoch najblizszych punktow
    //nX = (x[h] + x[h-1]) / 2;
    //nY = (y[h] + y[h-1]) / 2;
    //console.log("Z3: [" + nX + "," + nY + "]");
}