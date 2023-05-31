let [overview, breedingModernization, communication, clientSeedSystem] = [null, null, null, null];
// new BreedingModernization(),
// new Communication(),
// new ClientSeedSystem(),
// am4core.options.queue = true;
// am4core.options.onlyShowOnViewport = true;

const villages = [
	{
		name: "Mali",
		country_id: 5,
		lat: 17.570692,
		lang: -3.996166,
		partners: "NARS: Institute of Rural Economy (IER) <br>CGIAR: IITA, ICRISAT",
		Crops: "Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum",
	},
	{
		name: "Burkina Faso",
		country_id: 1,
		lat: 12.238333,
		lang: -1.561593,
		partners:
			"NARS: Environmental Institute for Agricultural Research (INERA) <br>CGIAR: IITA, ICRISAT",
		Crops: "Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum",
	},
	{
		name: "Ghana",
		country_id: 4,
		lat: 7.946527,
		lang: -1.023194,
		partners:
			"NARS: Council for Scientific and Industrial Research (CSIR) <br>CGIAR: IITA, ICRISAT",
		Crops: "Cowpea, Groundnut, Non-crop Specific",
	},
	{
		name: "Nigeria",
		country_id: 6,
		lat: 9.081999,
		lang: 8.675277,
		partners:
			"NARS: Institute for Agricultural Research (IAR) <br>CGIAR: IITA, ICRISAT <br>SFSA",
		Crops: "Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum",
	},
	{
		name: "Ethiopia",
		country_id: 2,
		lat: 9.145,
		lang: 40.489674,
		partners:
			"NARS: Ethiopian Institute of Agricultural Research (EIAR) <br>CGIAR: CIAT, ICRISAT",
		Crops: "Common bean, Finger millet, Sorghum",
	},
	{
		name: "Uganda",
		country_id: 10,
		lat: 1.5333554,
		lang: 32.2166578,
		partners:
			"NARS: National Agricultural Research Organisation (NARO) <br>CGIAR: CIAT, ICRISAT",
		Crops: "Common bean, Finger millet, Groundnut, Sorghum",
	},
	{
		name: "Tanzania",
		country_id: 8,
		lat: -6.5247123,
		lang: 35.7878438,
		partners:
			"NARS: Tanzania Agricultural Research Institute (TARI) <br>CGIAR: CIAT, ICRISAT <br>SFSA",
		Crops: "Common bean, Finger millet, Groundnut, Sorghum",
	},
];

const RCIH = [
	{
		rcih_name: "ICRISAT-WCA",
		location: "Bamako, Mali",
		rcih_id: "3",
		Organization: "ICRISAT",
		lat: "12.6132655",
		lang: "-7.9847391",
	},
	{
		rcih_name: "IITA",
		location: "Kano, Nigeria",
		rcih_id: "4",
		Organization: "IITA",
		lat: "11.8948389",
		lang: "8.5364136",
	},
	{
		rcih_name: "CIAT",
		location: "Kawanda, Uganda",
		rcih_id: "1",
		Organization: "CIAT",
		lat: "0.4172778",
		lang: "32.5355326",
	},
	{
		rcih_name: "ICRISAT-ESA",
		location: "Bulawayo, Zimbabwe",
		rcih_id: "2",
		Organization: "ICRISAT",
		lat: "-20.1560599",
		lang: "28.5887063",
	},
];


const imgUrl = $("#imgUrl").val();
$(".PO-tab").on("click", (env) => {
	const ele = $(env.target);
	const tabid = ele.data("tabid");
	if (tabid == 0) {
		$(".sidebar-container").hide();
		if (!overview) {
			overview = new Overview();
		}
	} else {
		$(".sidebar-container").show();
		if (tabid == 1 && !breedingModernization) {
			breedingModernization = new BreedingModernization();
		} else if (tabid == 2 && !communication) {
			communication = new Communication();
		} else if (tabid == 3 && !clientSeedSystem) {
			clientSeedSystem = new ClientSeedSystem();
		}
	}
});

const showLoader = () => {
	$("#main-body").hide();
	$("#loader-body").show();
};

const hideLoader = () => {
	$("#loader-body").hide();
	$("#main-body").show();
};
hideLoader();
$(".PO-tab.active").trigger("click");

const nodata_html = (
	height
) => `<div class="d-flex flex-column align-items-center justify-content-center" style="height:${
	height || "450px"
}">
  <h4 >No data available for the current selection</h4>
</div>`;

const countryIndexMap = new Map();
countryIndexMap.set("ESA-Common bean", 0);
countryIndexMap.set("ESA-Finger millet", 1);
countryIndexMap.set("ESA-Groundnut", 2);
countryIndexMap.set("ESA-Non-crop specific", 3);
countryIndexMap.set("ESA-Pearl millet", 4);
countryIndexMap.set("ESA-Sorghum", 5);
countryIndexMap.set("Ethiopia-Common bean", 6);
countryIndexMap.set("Ethiopia-Finger millet", 7);
countryIndexMap.set("Ethiopia-Sorghum", 8);
countryIndexMap.set("Tanzania-Common bean", 9);
countryIndexMap.set("Tanzania-Finger millet", 10);
countryIndexMap.set("Tanzania-Groundnut", 11);
countryIndexMap.set("Tanzania-Sorghum", 12);
countryIndexMap.set("Uganda-Common bean", 13);
countryIndexMap.set("Uganda-Finger millet", 14);
countryIndexMap.set("Uganda-Groundnut", 15);
countryIndexMap.set("Uganda-Sorghum", 16);
countryIndexMap.set("Burkina Faso-Cowpea", 17);
countryIndexMap.set("Burkina Faso-Groundnut", 18);
countryIndexMap.set("Burkina Faso-Pearl millet", 19);
countryIndexMap.set("Burkina Faso-Sorghum", 20);
countryIndexMap.set("Ghana-Cowpea", 21);
countryIndexMap.set("Ghana-Groundnut", 22);
countryIndexMap.set("Mali-Cowpea", 23);
countryIndexMap.set("Mali-Groundnut", 24);
countryIndexMap.set("Mali-Pearl millet", 25);
countryIndexMap.set("Mali-Sorghum", 26);
countryIndexMap.set("Nigeria-Cowpea", 27);
countryIndexMap.set("Nigeria-Groundnut", 28);
countryIndexMap.set("Nigeria-Pearl millet", 29);
countryIndexMap.set("Nigeria-Sorghum", 30);
countryIndexMap.set("WCA-Cowpea", 31);
countryIndexMap.set("WCA-Groundnut", 32);
countryIndexMap.set("WCA-Non-crop specific", 33);
countryIndexMap.set("WCA-Pearl millet", 34);
countryIndexMap.set("WCA-Sorghum", 35);

const countryIndexsort = (a, b) =>
	countryIndexMap.get(a.program_name) - countryIndexMap.get(b.program_name);

const cropIndexMap = new Map();
cropIndexMap.set("Common bean", 0);
cropIndexMap.set("Cowpea", 1);
cropIndexMap.set("Finger millet- ESA", 2);
cropIndexMap.set("Finger millet- WCA", 3);
cropIndexMap.set("Groundnut- ESA", 4);
cropIndexMap.set("Groundnut- WCA", 5);
cropIndexMap.set("Non-crop specific- ESA", 6);
cropIndexMap.set("Non-crop specific- WCA", 7);
cropIndexMap.set("Pearl millet- ESA", 8);
cropIndexMap.set("Pearl millet- WCA", 9);
cropIndexMap.set("Sorghum- ESA", 10);
cropIndexMap.set("Sorghum- WCA", 11);
const cropIndexsort = (a, b) =>
	cropIndexMap.get(a.program_name) - cropIndexMap.get(b.program_name);

const esaDivisonCountry = ["ESA", "Ethiopia", "Tanzania", "Uganda"];
const wcaDivisonCountry = ["WCA", "Burkina Faso", "Ghana", "Mali", "Nigeria"];

const countriesCodes = [
	{
		country_name: "Burkina Faso",
		country_id: "1",
		country_code: "BF",
	},
	{
		country_name: "Ethiopia",
		country_id: "2",
		country_code: "ET",
	},
	{
		country_name: "Ghana",
		country_id: "4",
		country_code: "GH",
	},
	{
		country_name: "Mali",
		country_id: "5",
		country_code: "ML",
	},
	{
		country_name: "Nigeria",
		country_id: "6",
		country_code: "NG",
	},
	{
		country_name: "Tanzania",
		country_id: "8",
		country_code: "TZ",
	},
	{
		country_name: "Uganda",
		country_id: "10",
		country_code: "UG",
	},
	{
		country_name: "Niger",
		country_code: "NE",
	},
	{
		country_name: "Kenya",
		country_code: "KE",
	},
	{
		country_name: "Malawi",
		country_code: "MW",
	},
	{
		country_name: "Zambia",
		country_code: "ZM",
	},
];
am4core.ready(function () {
	am4core.useTheme(am4themes_kelly);
});

$(".closebtn").on("click", () => {
  $(".column_left").hide();
  $(".card_expand").show();
  $(".scrollspy-example").removeClass("col-md-9 col-lg-9");
  $(".scrollspy-example").addClass("col-md-12 col-lg-12");
});

$(".card_expand").on("click", () => {
  $(".card_expand").hide();
  $(".column_left").show();
  $(".scrollspy-example").addClass("col-md-9 col-lg-9");
  $(".scrollspy-example").removeClass("col-md-12 col-lg-12");
});


$(".sidebar-container").hide();
$(".card_expand").hide();
