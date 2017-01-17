
var numer = Math.floor(Math.random()*5)+1;		
var cytaty = new Array(10);
var autor = new Array(10);

cytaty[0] = '"Kto czyta książki, żyje podwójnie"';
autor[0]="Umberto Eco";

cytaty[1] = '"Książka jest niczym ogród, który można włożyć do kieszeni"';
autor[1]="chińskie przysłowie";

cytaty[2] = '"Czytanie dobrych książek jest niczym rozmowa z najwspanialszymi ludźmi minionych czasów"';
autor[2]="Kartezjusz";

cytaty[3] = '"Książki są jak towarzystwo, które sobie człowiek dobiera"';
autor[3]="Monteskiusz";

cytaty[4] = '"Dobra książa to rodzaj alkoholu - też idzie do głowy"';
autor[4]="Magdalena Samozwaniec";

cytaty[5] = '"Telewizja to tylko zastępcza rozrywka dla mózgu, kto nie czyta, ten właściwie nie potrzebuje już głowy, nie mówiąc oczywiście o wyobraźni i fantazji"';
autor[5]="Billie Joe";

cytaty[6] = '"Wystrzegaj się ludzi jednej książki"';
autor[6]="Św. Tomasz";

cytaty[7] = '"Czytanie książek to najpiękniejsza zabawa, jaką sobie ludzkość wymyśliła."';
autor[7]="Wisława Szymborska";

cytaty[8] = '"Dom bez książek jest jak plaża bez słońca." ';
autor[8]="José Martí";

cytaty[9] = '"Pokój bez książek jest jak ciało bez duszy." ';
autor[9]="Cyceron";
		
function schowaj()
{
	$("#cytat").fadeOut(1000);
	$("#autor").fadeOut(1000);
}

		
function zmienslajd()
{
	numer++;
	if(numer>9) numer=0;			
	document.getElementById("cytat").innerHTML = cytaty[numer];
	document.getElementById("autor").innerHTML = autor[numer];
	$("#cytat").fadeIn(1000);
	$("#autor").fadeIn(1000);		
	setTimeout("zmienslajd()", 10000);
	setTimeout("schowaj()", 9000);		
}