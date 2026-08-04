/**
 * Load combinations from Choose Your Inverter-3.xlsx + rated permutations per model.
 * Each preset maps to one inverter; option value includes voltage when applicable.
 */
(function (global) {
var INVERTER_LOAD_PRESETS = [
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Compact shop",
    "appliances": "12 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "12 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Heavy shop",
    "appliances": "35 LED Bulb, 22 Fan, 3 LED TV, 2 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "35 bulbs \u00b7 22 fans \u00b7 3 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Heavy shop",
    "appliances": "40 LED Bulb, 25 Fan, 3 LED TV, 2 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "40 bulbs \u00b7 25 fans \u00b7 3 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Large shop",
    "appliances": "25 LED Bulb, 18 Fan, 2 LED TV, 2 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "25 bulbs \u00b7 18 fans \u00b7 2 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Large shop",
    "appliances": "30 LED Bulb, 20 Fan, 2 LED TV, 2 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "30 bulbs \u00b7 20 fans \u00b7 2 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Max load shop",
    "appliances": "50 LED Bulb, 30 Fan, 4 LED TV, 3 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "50 bulbs \u00b7 30 fans \u00b7 4 TVs \u00b7 3 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Medium shop",
    "appliances": "15 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "15 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Retail outlet",
    "appliances": "22 LED Bulb, 12 Fan, 3 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "22 bulbs \u00b7 12 fans \u00b7 3 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "12 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "12 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "15 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "18 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "18 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 12 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 12 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 1 LED TV, 2 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 1 LED TV, 3 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 3 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 3 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 3 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 4 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 4 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 18 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 18 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 20 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 20 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 22 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 22 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 25 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 25 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "20 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "22 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "22 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "25 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "25 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "28 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "28 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "30 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "30 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "35 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "35 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "40 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "40 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Showroom",
    "appliances": "28 LED Bulb, 15 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "470 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 96,
    "comboLabel": "28 bulbs \u00b7 15 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Compact shop",
    "appliances": "12 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "12 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Heavy shop",
    "appliances": "35 LED Bulb, 22 Fan, 3 LED TV, 2 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "35 bulbs \u00b7 22 fans \u00b7 3 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Heavy shop",
    "appliances": "40 LED Bulb, 25 Fan, 3 LED TV, 2 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "40 bulbs \u00b7 25 fans \u00b7 3 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Large shop",
    "appliances": "25 LED Bulb, 18 Fan, 2 LED TV, 2 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "25 bulbs \u00b7 18 fans \u00b7 2 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Large shop",
    "appliances": "30 LED Bulb, 20 Fan, 2 LED TV, 2 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "30 bulbs \u00b7 20 fans \u00b7 2 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Max load shop",
    "appliances": "50 LED Bulb, 30 Fan, 4 LED TV, 3 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "50 bulbs \u00b7 30 fans \u00b7 4 TVs \u00b7 3 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Medium shop",
    "appliances": "15 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Retail outlet",
    "appliances": "22 LED Bulb, 12 Fan, 3 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "22 bulbs \u00b7 12 fans \u00b7 3 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "12 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "12 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "18 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "18 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 12 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 12 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 1 LED TV, 2 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 2 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 1 LED TV, 3 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 3 routers"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 3 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 3 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 15 Fan, 4 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 15 fans \u00b7 4 TVs \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 18 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 18 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 20 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 20 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 22 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 22 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 25 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 25 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "22 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "22 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "25 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "25 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "28 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "28 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "30 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "30 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "35 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "35 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Shop/Office",
    "appliances": "40 LED Bulb, 15 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "40 bulbs \u00b7 15 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "5000",
    "excelModel": "Ligen Power 5000",
    "purpose": "Showroom",
    "appliances": "28 LED Bulb, 15 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "235 Mins",
    "rating": "5000VA/4000W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "28 bulbs \u00b7 15 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "10 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "10 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "12 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "12 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "12 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "12 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 10 Fan, 1 LED TV, 2 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 2 routers"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 10 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 10 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 10 Fan, 3 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 10 fans \u00b7 3 TVs \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 12 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 12 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 14 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 14 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 16 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 16 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 6 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 6 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "15 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "15 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "18 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "18 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "18 LED Bulb, 12 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "18 bulbs \u00b7 12 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "20 LED Bulb, 14 Fan, 2 LED TV, 2 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "20 bulbs \u00b7 14 fans \u00b7 2 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "22 LED Bulb, 10 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "22 bulbs \u00b7 10 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "3500",
    "excelModel": "Ligen Power 3500",
    "purpose": "Shop/Office",
    "appliances": "22 LED Bulb, 16 Fan, 3 LED TV, 2 Wifi Router",
    "backup": "340 Mins",
    "rating": "3500VA/2800W",
    "batteryAh": 100,
    "voltage": 48,
    "comboLabel": "22 bulbs \u00b7 16 fans \u00b7 3 TVs \u00b7 2 routers"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "10 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "10 bulbs \u00b7 7 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "5 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "5 bulbs \u00b7 7 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "6 LED Bulb, 6 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "6 bulbs \u00b7 6 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "6 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "6 bulbs \u00b7 7 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 6 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 6 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 7 Fan, 2 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 7 fans \u00b7 2 TVs \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 9 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 9 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "8 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "8 bulbs \u00b7 7 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "8 LED Bulb, 8 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "8 bulbs \u00b7 8 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "9 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "9 bulbs \u00b7 7 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "2000",
    "excelModel": "Ligen Power 2000",
    "purpose": "Home/Office",
    "appliances": "9 LED Bulb, 7 Fan, 2 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "180 Mins",
    "rating": "2000VA/1600W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "9 bulbs \u00b7 7 fans \u00b7 2 TVs \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "3 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "3 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "4 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "4 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "4 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "4 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "5 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "5 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 6 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "5 bulbs \u00b7 6 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "5 LED Bulb, 7 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "5 bulbs \u00b7 7 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "6 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "6 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "6 LED Bulb, 6 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "6 bulbs \u00b7 6 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1500",
    "excelModel": "Ligen Power 1500",
    "purpose": "Home/Office",
    "appliances": "7 LED Bulb, 5 Fan, 2 LED TV, 1 Wifi Router, 1 Cooler",
    "backup": "210 Mins",
    "rating": "1500VA/1200W",
    "batteryAh": 100,
    "voltage": 24,
    "comboLabel": "7 bulbs \u00b7 5 fans \u00b7 2 TVs \u00b7 1 router \u00b7 1 cooler"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "4 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "2 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "3 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "3 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "4 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 2 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "4 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "4 LED Bulb, 4 Fan, 2 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 4 fans \u00b7 2 TVs \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "4 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "4 LED Bulb, 6 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 6 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "5 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "5 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "5 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "5 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "1000",
    "excelModel": "Ligen Power 1000",
    "purpose": "4 BHK",
    "appliances": "6 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "180 Mins",
    "rating": "1000VA/800W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "6 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "3 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "2 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 2 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "2 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "3 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 2 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "3 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "3 LED Bulb, 5 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 5 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "4 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "4 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "850",
    "excelModel": "Ligen Power 850",
    "purpose": "2/3 BHK",
    "appliances": "5 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "210 Mins",
    "rating": "850VA/680W",
    "batteryAh": 100,
    "voltage": 12,
    "comboLabel": "5 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "2 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "1 LED Bulb, 1 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "1 bulb \u00b7 1 fan \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "1 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "1 bulb \u00b7 2 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "2 LED Bulb, 1 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 1 fan \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "2 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "2 LED Bulb, 4 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 4 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "3 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 2 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "3 LED Bulb, 3 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "3 bulbs \u00b7 3 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "600",
    "excelModel": "Ligen Power 600S",
    "purpose": "2 Bedroom",
    "appliances": "4 LED Bulb, 2 Fan, 1 LED TV, 1 Wifi Router",
    "backup": "150 Mins",
    "rating": "600VA/480W",
    "batteryAh": 50,
    "voltage": 12,
    "comboLabel": "4 bulbs \u00b7 2 fans \u00b7 1 TV \u00b7 1 router"
  },
  {
    "modelKey": "300",
    "excelModel": "Ligen Power 300",
    "purpose": "1 Room Office",
    "appliances": "1 LED Bulb, 1 Fan",
    "backup": "145 Mins",
    "rating": "300VA/240W",
    "batteryAh": 15,
    "voltage": 12,
    "comboLabel": "Recommended (datasheet)"
  },
  {
    "modelKey": "300",
    "excelModel": "Ligen Power 300",
    "purpose": "1 Room Office",
    "appliances": "1 LED Bulb, 2 Fan",
    "backup": "145 Mins",
    "rating": "300VA/240W",
    "batteryAh": 15,
    "voltage": 12,
    "comboLabel": "1 bulb \u00b7 2 fans"
  },
  {
    "modelKey": "300",
    "excelModel": "Ligen Power 300",
    "purpose": "1 Room Office",
    "appliances": "2 LED Bulb, 1 Fan",
    "backup": "145 Mins",
    "rating": "300VA/240W",
    "batteryAh": 15,
    "voltage": 12,
    "comboLabel": "2 bulbs \u00b7 1 fan"
  }
];

// 5 kVA · Ligen Power 5000 · 48V — excluded from finder dropdown
INVERTER_LOAD_PRESETS = INVERTER_LOAD_PRESETS.filter(function (p) {
  return !(p.modelKey === '5000' && p.voltage === 48);
});

var EXCEL_APPLIANCE_POWER = {
  'led bulb': 9,
  'fan': 60,
  'led tv': 70,
  'wifi router': 25,
  'wifi': 25,
  'cooler': 110,
  'bulb': 9,
  'tubelight': 40
};

function normalizeApplianceList(str) {
  return String(str || '').replace(/\s*,\s*/g, ', ').replace(/\s+/g, ' ').trim();
}

function kvaLabelFromRating(rating) {
  var s = String(rating || '');
  if (s.indexOf('5000') !== -1) return '5 kVA';
  if (s.indexOf('3500') !== -1) return '3.5 kVA';
  if (s.indexOf('2000') !== -1) return '2 kVA';
  if (s.indexOf('1500') !== -1) return '1.5 kVA';
  if (s.indexOf('1000') !== -1) return '1 kVA';
  if (s.indexOf('850') !== -1) return '0.85 kVA';
  if (s.indexOf('600') !== -1) return '0.6 kVA';
  if (s.indexOf('300') !== -1) return '0.3 kVA';
  return s.split('/')[0] || '';
}

function buildInverterPresetValue(preset) {
  var v = preset.voltage != null && preset.voltage !== '' ? String(preset.voltage) : '_';
  return 'preset|' + preset.modelKey + '|' + v + '|' + normalizeApplianceList(preset.appliances);
}

function parseInverterPresetValue(value) {
  if (!value || value.indexOf('preset|') !== 0) return null;
  var parts = value.split('|');
  if (parts.length < 3) return null;
  var modelKey = parts[1];
  var voltage = null;
  var appliances;
  if (parts.length >= 4 && parts[2] !== '_') {
    var vNum = parseInt(parts[2], 10);
    voltage = isNaN(vNum) ? null : vNum;
    appliances = parts.slice(3).join('|');
  } else if (parts.length >= 4 && parts[2] === '_') {
    appliances = parts.slice(3).join('|');
  } else {
    appliances = parts.slice(2).join('|');
  }
  for (var i = 0; i < INVERTER_LOAD_PRESETS.length; i++) {
    var p = INVERTER_LOAD_PRESETS[i];
    if (p.modelKey !== modelKey) continue;
    if (normalizeApplianceList(p.appliances) !== normalizeApplianceList(appliances)) continue;
    if (voltage != null && p.voltage != null && p.voltage !== voltage) continue;
    return p;
  }
  return { modelKey: modelKey, appliances: appliances, purpose: '', backup: '', rating: '', excelModel: '', voltage: voltage };
}

function calculateApplianceLoadWatts(equipment) {
  var totalPower = 0;
  var equipmentLower = String(equipment || '').toLowerCase();
  var matches = equipmentLower.match(/(\d+)\s+([^,]+?)(?=,\s*\d+|$)/g);
  var powerMap = typeof appliancePower !== 'undefined' ? appliancePower : EXCEL_APPLIANCE_POWER;
  if (matches) {
    matches.forEach(function (match) {
      var partMatch = match.trim().match(/(\d+)\s+(.+)/);
      if (!partMatch) return;
      var quantity = parseInt(partMatch[1], 10);
      var applianceName = partMatch[2].trim();
      var matched = false;
      var keys = Object.keys(powerMap).sort(function (a, b) { return b.length - a.length; });
      for (var i = 0; i < keys.length; i++) {
        if (applianceName.indexOf(keys[i]) !== -1) {
          totalPower += quantity * powerMap[keys[i]];
          matched = true;
          break;
        }
      }
      if (!matched) {
        if (applianceName.indexOf('tv') !== -1) totalPower += quantity * 70;
        else if (applianceName.indexOf('wifi') !== -1) totalPower += quantity * 25;
        else totalPower += quantity * 50;
      }
    });
  }
  return totalPower < 50 ? Math.max(totalPower, 50) : totalPower;
}

function presetOptionLabel(preset) {
  var combo = preset.comboLabel || preset.appliances;
  if (preset.comboLabel && preset.comboLabel.toLowerCase().indexOf('datasheet') !== -1) {
    return preset.purpose + ' — ' + combo + ' — ' + preset.appliances;
  }
  return preset.purpose + ' — ' + combo;
}

function populateInverterRequirementSelect(selectEl) {
  if (!selectEl) return;
  selectEl.innerHTML = '';
  var ph = document.createElement('option');
  ph.value = '';
  ph.textContent = '— Pick the closest match —';
  ph.style.color = 'rgba(255,255,255,0.6)';
  selectEl.appendChild(ph);

  var lastGroup = '';
  INVERTER_LOAD_PRESETS.forEach(function (preset) {
    var groupLabel = kvaLabelFromRating(preset.rating) + ' · ' + preset.excelModel;
    if (preset.modelKey === '5000' && preset.voltage === 96) {
      groupLabel += ' · 96V';
    }
    var currentOg;
    if (groupLabel !== lastGroup) {
      currentOg = document.createElement('optgroup');
      currentOg.label = groupLabel;
      selectEl.appendChild(currentOg);
      lastGroup = groupLabel;
    } else {
      currentOg = selectEl.querySelector('optgroup:last-of-type');
    }
    var opt = document.createElement('option');
    opt.value = buildInverterPresetValue(preset);
    opt.textContent = presetOptionLabel(preset);
    currentOg.appendChild(opt);
  });
}

function recommendationFromPreset(value, inverterSpecs) {
  var preset = parseInverterPresetValue(value);
  if (!preset || !inverterSpecs) return null;
  var spec = null;
  for (var i = 0; i < inverterSpecs.length; i++) {
    if (inverterSpecs[i].model === preset.modelKey) {
      spec = inverterSpecs[i];
      break;
    }
  }
  if (!spec) return null;
  var totalPower = calculateApplianceLoadWatts(preset.appliances);
  var requiredPower = Math.round(totalPower * 1.25);
  return {
    model: spec.model,
    name: spec.name,
    kva: spec.kva,
    type: spec.type,
    va: spec.va,
    url: spec.url,
    image: spec.image,
    calculatedPower: Math.round(totalPower),
    requiredPower: requiredPower,
    maxLoad: spec.maxLoad,
    purpose: preset.purpose,
    backup: preset.backup,
    batteryAh: preset.batteryAh,
    voltage: preset.voltage,
    appliances: preset.appliances,
    excelModel: preset.excelModel,
    comboLabel: preset.comboLabel
  };
}

global.INVERTER_LOAD_PRESETS = INVERTER_LOAD_PRESETS;
global.EXCEL_APPLIANCE_POWER = EXCEL_APPLIANCE_POWER;
global.populateInverterRequirementSelect = populateInverterRequirementSelect;
global.parseInverterPresetValue = parseInverterPresetValue;
global.recommendationFromPreset = recommendationFromPreset;
global.calculateApplianceLoadWatts = calculateApplianceLoadWatts;
global.buildInverterPresetValue = buildInverterPresetValue;
})(typeof window !== 'undefined' ? window : this);
