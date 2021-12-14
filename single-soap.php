<?php

get_header(); ?>

<style>
	/* RYK ALLE STYLES OVER I CUSTOM.CSS */
main {
  display: grid;
  grid-template-columns: 1fr minmax(0, 1000px) 1fr;
}
main section {
  grid-column: 2/3;
}

    img {
      display: block;
      width: 100%;
      height: auto;
      padding: 0;
      border: solid 1px black;
    }

	figure {
      margin: 0;
    }

    #produkt_container {
      display: grid;
    }

    #produkt_navn_single,
    #tekst_1,
    #tekst_2,
    #tekst_3,
    #køb,
    #tekst_4 {
      border: solid 1px black;
      padding: 0.5rem;
    }

    #produkt_navn_single {
      text-align: center;
    }

    #køb {
      display: grid;
      grid-template-columns: 1fr 1fr;
      text-align: center;
    }
	#antal {
      display: flex;
    }
    #antal p {
      border: solid 1px black;
      width: 3rem;
      height: 2.5rem;
      padding: 0.5rem;
    }

    button {
      background-color: black;
      color: white;
	  height: 3rem;
      border: solid 1px black;
	  padding: 0.5rem;
    }

	@media (min-width: 700px) {
      #produkt {
        grid-template-columns: 1fr 1fr;
      }

      #billede_container {
        grid-row: 2/5;
      }
      #produkt_navn_single {
        grid-column: 1/3;
      }
    }

	@media (min-width: 1000px) {
		#billede_container {
        grid-row: 2/7;
      }
	}
</style>

<main id="single_view">
	<section>
		<button id="tilbage_knap">Tilbage til shoppen</button>
	<article id="produkt_container">
        <h1 id="produkt_navn_single"></h1>

        <figure id="billede_container"><img class="produktbilleder" src="pine.png" alt="" /></figure>

        <div id="tekst_1">
          <h3>Beskrivelse og egenskaber</h3>
          <p id="produkt_beskrivelse"></p>
		  <p id="produkt_egenskab"></p>
        </div>

        <div id="tekst_2">
          <p id="produkt_pris"></p>
          <p id="produkt_vaegt"></p>
        </div>

        <div id="tekst_3">
          <h3>Tips og tricks</h3>
          <p id="produkt_tip"></p>
        </div>

        <div id="køb">
          <div id="antal">
            <p>-</p>
            <p>1</p>
            <p>+</p>
          </div>
          <button>Læg i kurv</button>
        </div>
        <div id="tekst_4">
          <h3>Ingredienser</h3>
        </div>
</article>
</section>
</main>

<script>
// Her starter JS. console.log for at tjekke om der er forbindelse
// console.log("hip hurra");

// Oprettelse af variabler
let produkter;
let ingredienser;

const url = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/soap/"+<?php echo get_the_ID() ?>;
const ingrediensUrl = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/contain";

// Oprettelse af function 'getJson' og definer hvordanm rest API'en hentes ind, og start function 'visProdukt'
async function getJson(){
	const response = await fetch(url);
	produkt = await response.json();
	
	const ingrediensData = await fetch(ingrediensUrl);
	ingredienser = await ingrediensData.json();

	console.log(produkt);

	// Kald funktioner
	visProdukt();
	visIngredienser();
}

// Oprettelse af function 'visIngredienser' og hent ud fra dynamisk indhold. Her ud fra kategorien "contain"
function visIngredienser(){
	ingredienser.forEach(ingrediens=>{
		if (produkt.contain.includes(parseInt(ingrediens.id)))
		document.querySelector("#tekst_4").innerHTML += `<p class="ingrediens" data-produkt="${ingrediens.id}">${ingrediens.name}</p>`
	})
	console.log("line Berner");
 
}

// Oprettelse af function 'start' (som starter så snart siden er loaded)
document.addEventListener("DOMContentLoaded", start);

// Sæt function 'start' igang og vis json/rest API indhold
function start(){
	// Kald funktion
	getJson()
}

// Oprettelse af function 'visProdukt' og definer hvilket indhold der skal vises
function visProdukt(){
	document.querySelector("#produkt_navn_single").textContent = produkt.navn;
	document.querySelector(".produktbilleder").src = produkt.billede[0].guid;
	document.querySelector(".produktbilleder").alt = produkt.navn;
	document.querySelector("#produkt_beskrivelse").textContent = produkt.beskrivelse;
	document.querySelector("#produkt_egenskab").textContent = produkt.egenskab;
	document.querySelector("#produkt_pris").textContent = produkt.pris;		
	document.querySelector("#produkt_vaegt").textContent = produkt.vaegt;
	document.querySelector("#produkt_tip").textContent = produkt.tip;
}
document.querySelector("#tilbage_knap").addEventListener("click", () => {
	window.history.back();
});

</script>

<?php
get_footer();
