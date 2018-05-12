# Units plugin for Craft CMS 3.x

Units is a plugin that can convert between any units of measure, and comes with a Field for content authors to use.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft-units

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Units.

You can also install Units via the **Plugin Store** in the Craft AdminCP.

## Units Overview

Units is a plugin that can convert between any units of measure, and comes with a Field for content authors to use.

You can convert from meters to feet, or liters to gallons, and anything else in between.

## Configuring Units

-Insert text here-

## Using Units

-Insert text here-

## Units Reference

Units uses the [PHP Units of Measure](https://github.com/PhpUnitsOfMeasure/php-units-of-measure) library, so it offers quite a bit of flexibility.

Below is a list of all of the types of physical quantity measures that Units supports, and a list of all of the units that can be used for each physical quantity.

The first item in the units list is the unit itself, and any sub-list items are aliases for that unit. For instance, `craft.units.length(10, 'meters')` is the same as `craft.units.length(10, 'm')`.

### Area
* m^2
   * m^2
   * m²
   * meter squared
   * square meter
   * square meters
   * meters squared
   * metre squared
   * metres squared
* mm^2
   * mm^2
   * mm²
   * millimeter squared
   * square millimeter
   * square millimeters
   * millimeters squared
   * millimetre squared
   * millimetres squared
* cm^2
   * cm^2
   * cm²
   * centimeter squared
   * square centimeter
   * square centimeters
   * centimeters squared
   * centimetre squared
   * centimetres squared
* dm^2
   * dm^2
   * dm²
   * decimeter squared
   * square decimeters
   * square decimeter
   * decimeters squared
   * decimetre squared
   * decimetres squared
* km^2
   * km^2
   * km²
   * kilometer squared
   * kilometers squared
   * square kilometer
   * square kilometers
   * kilometre squared
   * kilometres squared
* ft^2
   * ft^2
   * ft²
   * foot squared
   * square foot
   * square feet
   * feet squared
* in^2
   * in^2
   * in²
   * inch squared
   * square inch
   * square inches
   * inches squared
* mi^2
   * mi^2
   * mi²
   * mile squared
   * miles squared
   * square mile
   * square miles
* yd^2
   * yd^2
   * yd²
   * yard squared
   * yards squared
   * square yard
   * square yards
* a
   * a
   * are
   * ares
* daa
   * daa
   * decare
   * decares
* ha
   * ha
   * hectare
   * hectares
* ac
   * ac
   * acre
   * acres

### Mass
* kg
   * kg
   * kilogram
   * kilograms
* Yg
   * Yg
   * yottagram
   * yottagrams
* Zg
   * Zg
   * zettagram
   * zettagrams
* Eg
   * Eg
   * exagram
   * exagrams
* Pg
   * Pg
   * petagram
   * petagrams
* Tg
   * Tg
   * teragram
   * teragrams
* Gg
   * Gg
   * gigagram
   * gigagrams
* Mg
   * Mg
   * megagram
   * megagrams
* hg
   * hg
   * hectogram
   * hectograms
* dag
   * dag
   * decagram
   * decagrams
* g
   * g
   * gram
   * grams
* dg
   * dg
   * decigram
   * decigrams
* cg
   * cg
   * centigram
   * centigrams
* mg
   * mg
   * milligram
   * milligrams
* µg
   * µg
   * microgram
   * micrograms
* ng
   * ng
   * nanogram
   * nanograms
* pg
   * pg
   * picogram
   * picograms
* fg
   * fg
   * femtogram
   * femtograms
* ag
   * ag
   * attogram
   * attograms
* zg
   * zg
   * zeptogram
   * zeptograms
* yg
   * yg
   * yoctogram
   * yoctograms
* t
   * t
   * ton
   * tons
   * tonne
   * tonnes
* lb
   * lb
   * lbs
   * pound
   * pounds
* oz
   * oz
   * ounce
   * ounces
* st
   * st
   * stone
   * stones

### Quantity
* mol
   * mol
   * mole
   * moles
* Ymol
   * Ymol
   * yottamole
   * yottamoles
* Zmol
   * Zmol
   * zettamole
   * zettamoles
* Emol
   * Emol
   * examole
   * examoles
* Pmol
   * Pmol
   * petamole
   * petamoles
* Tmol
   * Tmol
   * teramole
   * teramoles
* Gmol
   * Gmol
   * gigamole
   * gigamoles
* Mmol
   * Mmol
   * megamole
   * megamoles
* kmol
   * kmol
   * kilomole
   * kilomoles
* hmol
   * hmol
   * hectomole
   * hectomoles
* damol
   * damol
   * decamole
   * decamoles
* dmol
   * dmol
   * decimole
   * decimoles
* cmol
   * cmol
   * centimole
   * centimoles
* mmol
   * mmol
   * millimole
   * millimoles
* µmol
   * µmol
   * micromole
   * micromoles
* nmol
   * nmol
   * nanomole
   * nanomoles
* pmol
   * pmol
   * picomole
   * picomoles
* fmol
   * fmol
   * femtomole
   * femtomoles
* amol
   * amol
   * attomole
   * attomoles
* zmol
   * zmol
   * zeptomole
   * zeptomoles
* ymol
   * ymol
   * yoctomole
   * yoctomoles

### Pressure
* Pa
   * Pa
   * pascal
* YPa
   * YPa
   * yottapascal
* ZPa
   * ZPa
   * zettapascal
* EPa
   * EPa
   * exapascal
* PPa
   * PPa
   * petapascal
* TPa
   * TPa
   * terapascal
* GPa
   * GPa
   * gigapascal
* MPa
   * MPa
   * megapascal
* kPa
   * kPa
   * kilopascal
* hPa
   * hPa
   * hectopascal
* daPa
   * daPa
   * decapascal
* dPa
   * dPa
   * decipascal
* cPa
   * cPa
   * centipascal
* mPa
   * mPa
   * millipascal
* µPa
   * µPa
   * micropascal
* nPa
   * nPa
   * nanopascal
* pPa
   * pPa
   * picopascal
* fPa
   * fPa
   * femtopascal
* aPa
   * aPa
   * attopascal
* zPa
   * zPa
   * zeptopascal
* yPa
   * yPa
   * yoctopascal
* atm
   * atm
   * atmosphere
   * atmospheres
* bar
* Ybar
* Zbar
* Ebar
* Pbar
* Tbar
* Gbar
* Mbar
* kbar
* hbar
* dabar
* dbar
* cbar
* mbar
* µbar
* nbar
* pbar
* fbar
* abar
* zbar
* ybar
* inHg
   * inHg
   * inches of mercury
* mmHg
   * mmHg
   * millimeters of mercury
   * millimetres of mercury
   * torr
* psi
   * psi
   * pounds per square inch

### Angle
* rad
   * rad
   * radian
   * radians
* Yrad
   * Yrad
   * yottaradian
   * yottaradians
* Zrad
   * Zrad
   * zettaradian
   * zettaradians
* Erad
   * Erad
   * exaradian
   * exaradians
* Prad
   * Prad
   * petaradian
   * petaradians
* Trad
   * Trad
   * teraradian
   * teraradians
* Grad
   * Grad
   * gigaradian
   * gigaradians
* Mrad
   * Mrad
   * megaradian
   * megaradians
* krad
   * krad
   * kiloradian
   * kiloradians
* hrad
   * hrad
   * hectoradian
   * hectoradians
* darad
   * darad
   * decaradian
   * decaradians
* drad
   * drad
   * deciradian
   * deciradians
* crad
   * crad
   * centiradian
   * centiradians
* mrad
   * mrad
   * milliradian
   * milliradians
* µrad
   * µrad
   * microradian
   * microradians
* nrad
   * nrad
   * nanoradian
   * nanoradians
* prad
   * prad
   * picoradian
   * picoradians
* frad
   * frad
   * femtoradian
   * femtoradians
* arad
   * arad
   * attoradian
   * attoradians
* zrad
   * zrad
   * zeptoradian
   * zeptoradians
* yrad
   * yrad
   * yoctoradian
   * yoctoradians
* deg
   * deg
   * °
   * degree
   * degrees
* Ydeg
   * Ydeg
   * yottadegree
   * yottadegrees
* Zdeg
   * Zdeg
   * zettadegree
   * zettadegrees
* Edeg
   * Edeg
   * exadegree
   * exadegrees
* Pdeg
   * Pdeg
   * petadegree
   * petadegrees
* Tdeg
   * Tdeg
   * teradegree
   * teradegrees
* Gdeg
   * Gdeg
   * gigadegree
   * gigadegrees
* Mdeg
   * Mdeg
   * megadegree
   * megadegrees
* kdeg
   * kdeg
   * kilodegree
   * kilodegrees
* hdeg
   * hdeg
   * hectodegree
   * hectodegrees
* dadeg
   * dadeg
   * decadegree
   * decadegrees
* ddeg
   * ddeg
   * decidegree
   * decidegrees
* cdeg
   * cdeg
   * centidegree
   * centidegrees
* mdeg
   * mdeg
   * millidegree
   * millidegrees
* µdeg
   * µdeg
   * microdegree
   * microdegrees
* ndeg
   * ndeg
   * nanodegree
   * nanodegrees
* pdeg
   * pdeg
   * picodegree
   * picodegrees
* fdeg
   * fdeg
   * femtodegree
   * femtodegrees
* adeg
   * adeg
   * attodegree
   * attodegrees
* zdeg
   * zdeg
   * zeptodegree
   * zeptodegrees
* ydeg
   * ydeg
   * yoctodegree
   * yoctodegrees
* arcmin
   * arcmin
   * ′
   * arcminute
   * arcminutes
   * amin
   * am
   * MOA
   * arcsecond
   * arcseconds
* arcsec
   * arcsec
   * ″
   * asec
   * as
* yottaarcsec
   * yottaarcsec
   * yottaarcsecond
   * yottaarcseconds
   * Yasec
   * Yas
* zettaarcsec
   * zettaarcsec
   * zettaarcsecond
   * zettaarcseconds
   * Zasec
   * Zas
* exaarcsec
   * exaarcsec
   * exaarcsecond
   * exaarcseconds
   * Easec
   * Eas
* petaarcsec
   * petaarcsec
   * petaarcsecond
   * petaarcseconds
   * Pasec
   * Pas
* teraarcsec
   * teraarcsec
   * teraarcsecond
   * teraarcseconds
   * Tasec
   * Tas
* gigaarcsec
   * gigaarcsec
   * gigaarcsecond
   * gigaarcseconds
   * Gasec
   * Gas
* megaarcsec
   * megaarcsec
   * megaarcsecond
   * megaarcseconds
   * Masec
   * Mas
* kiloarcsec
   * kiloarcsec
   * kiloarcsecond
   * kiloarcseconds
   * kasec
   * kas
* hectoarcsec
   * hectoarcsec
   * hectoarcsecond
   * hectoarcseconds
   * hasec
   * has
* decaarcsec
   * decaarcsec
   * decaarcsecond
   * decaarcseconds
   * daasec
   * daas
* deciarcsec
   * deciarcsec
   * deciarcsecond
   * deciarcseconds
   * dasec
   * das
* centiarcsec
   * centiarcsec
   * centiarcsecond
   * centiarcseconds
   * casec
   * cas
* milliarcsec
   * milliarcsec
   * milliarcsecond
   * milliarcseconds
   * masec
   * mas
* microarcsec
   * microarcsec
   * microarcsecond
   * microarcseconds
   * µasec
   * µas
* nanoarcsec
   * nanoarcsec
   * nanoarcsecond
   * nanoarcseconds
   * nasec
   * nas
* picoarcsec
   * picoarcsec
   * picoarcsecond
   * picoarcseconds
   * pasec
   * pas
* femtoarcsec
   * femtoarcsec
   * femtoarcsecond
   * femtoarcseconds
   * fasec
   * fas
* attoarcsec
   * attoarcsec
   * attoarcsecond
   * attoarcseconds
   * aasec
   * aas
* zeptoarcsec
   * zeptoarcsec
   * zeptoarcsecond
   * zeptoarcseconds
   * zasec
   * zas
* yoctoarcsec
   * yoctoarcsec
   * yoctoarcsecond
   * yoctoarcseconds
   * yasec
   * yas

### Time
* s
   * s
   * sec
   * secs
   * second
   * seconds
* Ys
   * Ys
   * yottasec
   * yottasecs
   * yottasecond
   * yottaseconds
* Zs
   * Zs
   * zettasec
   * zettasecs
   * zettasecond
   * zettaseconds
* Es
   * Es
   * exasec
   * exasecs
   * exasecond
   * exaseconds
* Ps
   * Ps
   * petasec
   * petasecs
   * petasecond
   * petaseconds
* Ts
   * Ts
   * terasec
   * terasecs
   * terasecond
   * teraseconds
* Gs
   * Gs
   * gigasec
   * gigasecs
   * gigasecond
   * gigaseconds
* Ms
   * Ms
   * megasec
   * megasecs
   * megasecond
   * megaseconds
* ks
   * ks
   * kilosec
   * kilosecs
   * kilosecond
   * kiloseconds
* hs
   * hs
   * hectosec
   * hectosecs
   * hectosecond
   * hectoseconds
* das
   * das
   * decasec
   * decasecs
   * decasecond
   * decaseconds
* ds
   * ds
   * decisec
   * decisecs
   * decisecond
   * deciseconds
* cs
   * cs
   * centisec
   * centisecs
   * centisecond
   * centiseconds
* ms
   * ms
   * millisec
   * millisecs
   * millisecond
   * milliseconds
* µs
   * µs
   * microsec
   * microsecs
   * microsecond
   * microseconds
* ns
   * ns
   * nanosec
   * nanosecs
   * nanosecond
   * nanoseconds
* ps
   * ps
   * picosec
   * picosecs
   * picosecond
   * picoseconds
* fs
   * fs
   * femtosec
   * femtosecs
   * femtosecond
   * femtoseconds
* as
   * as
   * attosec
   * attosecs
   * attosecond
   * attoseconds
* zs
   * zs
   * zeptosec
   * zeptosecs
   * zeptosecond
   * zeptoseconds
* ys
   * ys
   * yoctosec
   * yoctosecs
   * yoctosecond
   * yoctoseconds
* m
   * m
   * min
   * mins
   * minute
   * minutes
* h
   * h
   * hr
   * hrs
   * hour
   * hours
* d
   * d
   * day
   * days
* w
   * w
   * wk
   * wks
   * week
   * weeks
* yr
   * yr
   * year
   * years
   * gregorian year
   * gregorian years
* decade
   * decade
   * decades
* century
   * century
   * centuries
* millennium
   * millennium
   * millennia
* jyr
   * jyr
   * julian year
   * julian years

### Volume
* m^3
   * m^3
   * m³
   * cubic meter
   * cubic meters
   * cubic metre
   * cubic metres
* mm^3
   * mm^3
   * mm³
   * cubic millimeter
   * cubic millimeters
   * cubic millimetre
   * cubic millimetres
* cm^3
   * cm^3
   * cm³
   * cubic centimeter
   * cubic centimeters
   * cubic centimetre
   * cubic centimetres
* dm^3
   * dm^3
   * dm³
   * cubic decimeter
   * cubic decimeters
   * cubic decimetre
   * cubic decimetres
* km^3
   * km^3
   * km³
   * cubic kilometer
   * cubic kilometers
   * cubic kilometre
   * cubic kilometres
* ft^3
   * ft^3
   * ft³
   * cubic foot
   * cubic feet
* in^3
   * in^3
   * in³
   * cubic inch
   * cubic inches
* yd^3
   * yd^3
   * yd³
   * cubic yard
   * cubic yards
* ml
   * ml
   * milliliter
   * milliliters
   * millilitre
   * millilitres
* cl
   * cl
   * centiliter
   * centiliters
   * centilitre
   * centilitres
* dl
   * dl
   * deciliter
   * deciliters
   * decilitre
   * decilitres
* l
   * l
   * liter
   * liters
   * litre
   * litres
* dal
   * dal
   * decaliter
   * decaliters
   * decalitre
   * decalitres
* hl
   * hl
   * hectoliter
   * hectoliters
   * hectolitre
   * hectolitres
* cup
   * cup
   * cup
   * cups
* tsp
   * tsp
   * teaspoon
   * teaspoons
* tbsp
   * tbsp
   * tablespoon
   * tablespoons
* gal
   * gal
   * gallon
   * gallons
   * us gal
* qt
   * qt
   * quart
   * quarts
   * qts
   * liq qt
* fl oz
   * fl oz
   * fluid ounce
   * fluid ounces
   * fluid oz
   * fl. oz.
   * oz. fl.
* pt
   * pt
   * pint
   * pints
   * liq pt

### Acceleration
* m/s^2
   * m/s^2
   * m/s²
   * meter per second squared
   * meters per second squared
   * metre per second squared
   * metres per second squared

### SolidAngle
* sr
   * sr
   * steradian
   * steradians
* Ysr
   * Ysr
   * yottasteradian
   * yottasteradians
* Zsr
   * Zsr
   * zettasteradian
   * zettasteradians
* Esr
   * Esr
   * exasteradian
   * exasteradians
* Psr
   * Psr
   * petasteradian
   * petasteradians
* Tsr
   * Tsr
   * terasteradian
   * terasteradians
* Gsr
   * Gsr
   * gigasteradian
   * gigasteradians
* Msr
   * Msr
   * megasteradian
   * megasteradians
* ksr
   * ksr
   * kilosteradian
   * kilosteradians
* hsr
   * hsr
   * hectosteradian
   * hectosteradians
* dasr
   * dasr
   * decasteradian
   * decasteradians
* dsr
   * dsr
   * decisteradian
   * decisteradians
* csr
   * csr
   * centisteradian
   * centisteradians
* msr
   * msr
   * millisteradian
   * millisteradians
* µsr
   * µsr
   * microsteradian
   * microsteradians
* nsr
   * nsr
   * nanosteradian
   * nanosteradians
* psr
   * psr
   * picosteradian
   * picosteradians
* fsr
   * fsr
   * femtosteradian
   * femtosteradians
* asr
   * asr
   * attosteradian
   * attosteradians
* zsr
   * zsr
   * zeptosteradian
   * zeptosteradians
* ysr
   * ysr
   * yoctosteradian
   * yoctosteradians

### Energy
* J
   * J
   * joule
   * joules
* YJ
   * YJ
   * yottajoule
   * yottajoules
* ZJ
   * ZJ
   * zettajoule
   * zettajoules
* EJ
   * EJ
   * exajoule
   * exajoules
* PJ
   * PJ
   * petajoule
   * petajoules
* TJ
   * TJ
   * terajoule
   * terajoules
* GJ
   * GJ
   * gigajoule
   * gigajoules
* MJ
   * MJ
   * megajoule
   * megajoules
* kJ
   * kJ
   * kilojoule
   * kilojoules
* hJ
   * hJ
   * hectojoule
   * hectojoules
* daJ
   * daJ
   * decajoule
   * decajoules
* dJ
   * dJ
   * decijoule
   * decijoules
* cJ
   * cJ
   * centijoule
   * centijoules
* mJ
   * mJ
   * millijoule
   * millijoules
* µJ
   * µJ
   * microjoule
   * microjoules
* nJ
   * nJ
   * nanojoule
   * nanojoules
* pJ
   * pJ
   * picojoule
   * picojoules
* fJ
   * fJ
   * femtojoule
   * femtojoules
* aJ
   * aJ
   * attojoule
   * attojoules
* zJ
   * zJ
   * zeptojoule
   * zeptojoules
* yJ
   * yJ
   * yoctojoule
   * yoctojoules
* Wh
   * Wh
   * watt hour
   * watt hours
* YWh
   * YWh
   * yottawatt hour
   * yottawatt hours
* ZWh
   * ZWh
   * zettawatt hour
   * zettawatt hours
* EWh
   * EWh
   * exawatt hour
   * exawatt hours
* PWh
   * PWh
   * petawatt hour
   * petawatt hours
* TWh
   * TWh
   * terawatt hour
   * terawatt hours
* GWh
   * GWh
   * gigawatt hour
   * gigawatt hours
* MWh
   * MWh
   * megawatt hour
   * megawatt hours
* kWh
   * kWh
   * kilowatt hour
   * kilowatt hours
* hWh
   * hWh
   * hectowatt hour
   * hectowatt hours
* daWh
   * daWh
   * decawatt hour
   * decawatt hours
* dWh
   * dWh
   * deciwatt hour
   * deciwatt hours
* cWh
   * cWh
   * centiwatt hour
   * centiwatt hours
* mWh
   * mWh
   * milliwatt hour
   * milliwatt hours
* µWh
   * µWh
   * microwatt hour
   * microwatt hours
* nWh
   * nWh
   * nanowatt hour
   * nanowatt hours
* pWh
   * pWh
   * picowatt hour
   * picowatt hours
* fWh
   * fWh
   * femtowatt hour
   * femtowatt hours
* aWh
   * aWh
   * attowatt hour
   * attowatt hours
* zWh
   * zWh
   * zeptowatt hour
   * zeptowatt hours
* yWh
   * yWh
   * yoctowatt hour
   * yoctowatt hours

### Velocity
* m/s
   * m/s
   * meters/sec
   * meters per second
   * meter per second
   * metres per second
   * metre per second
* km/h
   * km/h
   * km/hour
   * kilometer per hour
   * kilometers per hour
   * kilometre per hour
   * kilometres per hour
* ft/s
   * ft/s
   * feet/sec
   * feet per second
* mph
   * mph
   * miles/hour
   * miles per hour
* knot
   * knot
   * knots

### Temperature
* K
   * K
   * °K
   * kelvin
* YK
   * YK
   * yottakelvin
* ZK
   * ZK
   * zettakelvin
* EK
   * EK
   * exakelvin
* PK
   * PK
   * petakelvin
* TK
   * TK
   * terakelvin
* GK
   * GK
   * gigakelvin
* MK
   * MK
   * megakelvin
* kK
   * kK
   * kilokelvin
* hK
   * hK
   * hectokelvin
* daK
   * daK
   * decakelvin
* dK
   * dK
   * decikelvin
* cK
   * cK
   * centikelvin
* mK
   * mK
   * millikelvin
* µK
   * µK
   * microkelvin
* nK
   * nK
   * nanokelvin
* pK
   * pK
   * picokelvin
* fK
   * fK
   * femtokelvin
* aK
   * aK
   * attokelvin
* zK
   * zK
   * zeptokelvin
* yK
   * yK
   * yoctokelvin
* °C
   * °C
   * C
   * celsius
* °F
   * °F
   * F
   * fahrenheit
* °R
   * °R
   * R
   * rankine
* °De
   * °De
   * De
   * delisle
* °N
   * °N
   * N
   * newton
* °Ré
   * °Ré
   * °Re
   * Ré
   * Re
   * réaumur
   * reaumur
* °Rø
   * °Rø
   * °Ro
   * Rø
   * Ro
   * rømer
   * romer

### ElectricCurrent
* A
   * A
   * amp
   * amps
   * ampere
   * amperes
* YA
   * YA
   * yottaamp
   * yottaamps
   * yottaampere
   * yottaamperes
* ZA
   * ZA
   * zettaamp
   * zettaamps
   * zettaampere
   * zettaamperes
* EA
   * EA
   * exaamp
   * exaamps
   * exaampere
   * exaamperes
* PA
   * PA
   * petaamp
   * petaamps
   * petaampere
   * petaamperes
* TA
   * TA
   * teraamp
   * teraamps
   * teraampere
   * teraamperes
* GA
   * GA
   * gigaamp
   * gigaamps
   * gigaampere
   * gigaamperes
* MA
   * MA
   * megaamp
   * megaamps
   * megaampere
   * megaamperes
* kA
   * kA
   * kiloamp
   * kiloamps
   * kiloampere
   * kiloamperes
* hA
   * hA
   * hectoamp
   * hectoamps
   * hectoampere
   * hectoamperes
* daA
   * daA
   * decaamp
   * decaamps
   * decaampere
   * decaamperes
* dA
   * dA
   * deciamp
   * deciamps
   * deciampere
   * deciamperes
* cA
   * cA
   * centiamp
   * centiamps
   * centiampere
   * centiamperes
* mA
   * mA
   * milliamp
   * milliamps
   * milliampere
   * milliamperes
* µA
   * µA
   * microamp
   * microamps
   * microampere
   * microamperes
* nA
   * nA
   * nanoamp
   * nanoamps
   * nanoampere
   * nanoamperes
* pA
   * pA
   * picoamp
   * picoamps
   * picoampere
   * picoamperes
* fA
   * fA
   * femtoamp
   * femtoamps
   * femtoampere
   * femtoamperes
* aA
   * aA
   * attoamp
   * attoamps
   * attoampere
   * attoamperes
* zA
   * zA
   * zeptoamp
   * zeptoamps
   * zeptoampere
   * zeptoamperes
* yA
   * yA
   * yoctoamp
   * yoctoamps
   * yoctoampere
   * yoctoamperes

### Length
* m
   * m
   * meter
   * meters
   * metre
   * metres
* Ym
   * Ym
   * yottameter
   * yottameters
   * yottametre
   * yottametres
* Zm
   * Zm
   * zettameter
   * zettameters
   * zettametre
   * zettametres
* Em
   * Em
   * exameter
   * exameters
   * exametre
   * exametres
* Pm
   * Pm
   * petameter
   * petameters
   * petametre
   * petametres
* Tm
   * Tm
   * terameter
   * terameters
   * terametre
   * terametres
* Gm
   * Gm
   * gigameter
   * gigameters
   * gigametre
   * gigametres
* Mm
   * Mm
   * megameter
   * megameters
   * megametre
   * megametres
* km
   * km
   * kilometer
   * kilometers
   * kilometre
   * kilometres
* hm
   * hm
   * hectometer
   * hectometers
   * hectometre
   * hectometres
* dam
   * dam
   * decameter
   * decameters
   * decametre
   * decametres
* dm
   * dm
   * decimeter
   * decimeters
   * decimetre
   * decimetres
* cm
   * cm
   * centimeter
   * centimeters
   * centimetre
   * centimetres
* mm
   * mm
   * millimeter
   * millimeters
   * millimetre
   * millimetres
* µm
   * µm
   * micrometer
   * micrometers
   * micrometre
   * micrometres
* nm
   * nm
   * nanometer
   * nanometers
   * nanometre
   * nanometres
* pm
   * pm
   * picometer
   * picometers
   * picometre
   * picometres
* fm
   * fm
   * femtometer
   * femtometers
   * femtometre
   * femtometres
* am
   * am
   * attometer
   * attometers
   * attometre
   * attometres
* zm
   * zm
   * zeptometer
   * zeptometers
   * zeptometre
   * zeptometres
* ym
   * ym
   * yoctometer
   * yoctometers
   * yoctometre
   * yoctometres
* ft
   * ft
   * foot
   * feet
* in
   * in
   * inch
   * inches
* mi
   * mi
   * mile
   * miles
* yd
   * yd
   * yard
   * yards
* M
   * M
   * nautical mile
   * nautical miles
   * nmi
   * NM
* mil
* AU
   * AU
   * au
   * astronomical unit
   * astronomical units

### LuminousIntensity
* cd
   * cd
   * candela
* Ycd
   * Ycd
   * yottacandela
* Zcd
   * Zcd
   * zettacandela
* Ecd
   * Ecd
   * exacandela
* Pcd
   * Pcd
   * petacandela
* Tcd
   * Tcd
   * teracandela
* Gcd
   * Gcd
   * gigacandela
* Mcd
   * Mcd
   * megacandela
* kcd
   * kcd
   * kilocandela
* hcd
   * hcd
   * hectocandela
* dacd
   * dacd
   * decacandela
* dcd
   * dcd
   * decicandela
* ccd
   * ccd
   * centicandela
* mcd
   * mcd
   * millicandela
* µcd
   * µcd
   * microcandela
* ncd
   * ncd
   * nanocandela
* pcd
   * pcd
   * picocandela
* fcd
   * fcd
   * femtocandela
* acd
   * acd
   * attocandela
* zcd
   * zcd
   * zeptocandela
* ycd
   * ycd
   * yoctocandela
   
## Units Roadmap

Some things to do, and ideas for potential features:

* Add the ability to control what units appear in the list (because who uses _yottameters_?)

Brought to you by [nystudio107](https://nystudio107.com/)
