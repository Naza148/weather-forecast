Weather forecast service
===
Example API request:
---
* GET /forecast?city=London

Response:
```json
{
  "location": {
    "name": "London",
    "country": "United Kingdom"
  },
  "temperature": 5,
  "weather_icons": [
    "https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0002_sunny_intervals.png"
  ],
  "weather_descriptions": [
    "Partly cloudy"
  ],
  "wind_speed": 11,
  "wind_degree": 90,
  "wind_dir": "E",
  "pressure": 1015,
  "precip": 0,
  "humidity": 81,
  "cloudcover": 75,
  "feelslike": 2,
  "uv_index": 3
}
```
