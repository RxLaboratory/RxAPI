<?php
    require_once($__ROOT__."/config.php");
    require_once($__ROOT__."/reply.php");

    // language codes / language names associative array
    // Generated from https://github.com/unicode-org/cldr
    $languageNames = array("pd" => "Ch'ti / Picard", "af" => "Afrikaans", "agq" => "Aghem", "ak" => "Akan", "am" => "\u{12a0}\u{121b}\u{122d}\u{129b}", "ar" => "\u{0627}\u{0644}\u{0639}\u{0631}\u{0628}\u{064a}\u{0629}", "as" => "\u{0985}\u{09b8}\u{09ae}\u{09c0}\u{09af}\u{09bc}\u{09be}", "asa" => "Kipare", "ast" => "Asturianu", "az" => "Az\u{0259}rbaycan", "bas" => "\u{0181}\u{00e0}s\u{00e0}a", "be" => "\u{0411}\u{0435}\u{043b}\u{0430}\u{0440}\u{0443}\u{0441}\u{043a}\u{0430}\u{044f}", "bem" => "Ichibemba", "bez" => "Hibena", "bg" => "\u{0411}\u{044a}\u{043b}\u{0433}\u{0430}\u{0440}\u{0441}\u{043a}\u{0438}", "bm" => "Bamanakan", "bn" => "\u{09ac}\u{09be}\u{0982}\u{09b2}\u{09be}", "bo" => "\u{0f56}\u{0f7c}\u{0f51}\u{0f0b}\u{0f66}\u{0f90}\u{0f51}\u{0f0b}", "br" => "Brezhoneg", "brx" => "\u{092c}\u{0930}\u{2019}", "bs" => "Bosanski", "ca" => "Catal\u{00e0}", "ccp" => "\u{d804}\u{dd0c}\u{d804}\u{dd0b}\u{d804}\u{dd34}\u{d804}\u{dd1f}\u{d804}\u{dd33}\u{d804}\u{dd26}", "ce" => "\u{041d}\u{043e}\u{0445}\u{0447}\u{0438}\u{0439}\u{043d}", "ceb" => "Binisaya", "cgg" => "Rukiga", "chr" => "\u{13e3}\u{ab83}\u{ab79}", "ckb" => "\u{06a9}\u{0648}\u{0631}\u{062f}\u{06cc}\u{06cc} \u{0646}\u{0627}\u{0648}\u{06d5}\u{0646}\u{062f}\u{06cc}", "cs" => "\u{010c}e\u{0161}tina", "cy" => "Cymraeg", "da" => "Dansk", "dav" => "Kitaita", "de" => "Deutsch", "dje" => "Zarmaciine", "doi" => "\u{0921}\u{094b}\u{0917}\u{0930}\u{0940}", "dsb" => "Dolnoserb\u{0161}\u{0107}ina", "dua" => "Du\u{00e1}l\u{00e1}", "dyo" => "Joola", "dz" => "\u{0f62}\u{0fab}\u{0f7c}\u{0f44}\u{0f0b}\u{0f41}", "ebu" => "K\u{0129}embu", "ee" => "E\u{028b}egbe", "el" => "\u{0395}\u{03bb}\u{03bb}\u{03b7}\u{03bd}\u{03b9}\u{03ba}\u{03ac}", "en" => "English", "eo" => "Esperanto", "es" => "Espa\u{00f1}ol", "et" => "Eesti", "eu" => "Euskara", "ewo" => "Ewondo", "fa" => "\u{0641}\u{0627}\u{0631}\u{0633}\u{06cc}", "ff" => "Pulaar", "fi" => "Suomi", "fil" => "Filipino", "fo" => "F\u{00f8}royskt", "fr" => "Fran\u{00e7}ais", "fur" => "Furlan", "fy" => "Frysk", "ga" => "Gaeilge", "gd" => "G\u{00e0}idhlig", "gl" => "Galego", "gsw" => "Schwiizert\u{00fc}\u{00fc}tsch", "gu" => "\u{0a97}\u{0ac1}\u{0a9c}\u{0ab0}\u{0abe}\u{0aa4}\u{0ac0}", "guz" => "Ekegusii", "gv" => "Gaelg", "ha" => "Hausa", "haw" => "\u{02bb}\u{014d}lelo hawai\u{02bb}i", "he" => "\u{05e2}\u{05d1}\u{05e8}\u{05d9}\u{05ea}", "hi" => "\u{0939}\u{093f}\u{0928}\u{094d}\u{0926}\u{0940}", "hr" => "Hrvatski", "hsb" => "Hornjoserb\u{0161}\u{0107}ina", "hu" => "Magyar", "hy" => "\u{0540}\u{0561}\u{0575}\u{0565}\u{0580}\u{0565}\u{0576}", "ia" => "Interlingua", "id" => "Indonesia", "ig" => "Igbo", "ii" => "\u{a188}\u{a320}\u{a259}", "is" => "\u{00cd}slenska", "it" => "Italiano", "ja" => "\u{65e5}\u{672c}\u{8a9e}", "jgo" => "Nda\u{a78c}a", "jmc" => "Kimachame", "jv" => "Jawa", "ka" => "\u{10e5}\u{10d0}\u{10e0}\u{10d7}\u{10e3}\u{10da}\u{10d8}", "kab" => "Taqbaylit", "kam" => "Kikamba", "kde" => "Chimakonde", "kea" => "Kabuverdianu", "kgp" => "Kanhg\u{00e1}g", "khq" => "Koyra ciini", "ki" => "Gikuyu", "kk" => "\u{049a}\u{0430}\u{0437}\u{0430}\u{049b} \u{0442}\u{0456}\u{043b}\u{0456}", "kkj" => "Kak\u{0254}", "kl" => "Kalaallisut", "kln" => "Kalenjin", "km" => "\u{1781}\u{17d2}\u{1798}\u{17c2}\u{179a}", "kn" => "\u{0c95}\u{0ca8}\u{0ccd}\u{0ca8}\u{0ca1}", "ko" => "\u{d55c}\u{ad6d}\u{c5b4}", "kok" => "\u{0915}\u{094b}\u{0902}\u{0915}\u{0923}\u{0940}", "ks" => "\u{06a9}\u{0672}\u{0634}\u{064f}\u{0631}", "ksb" => "Kishambaa", "ksf" => "Rikpa", "ksh" => "K\u{00f6}lsch", "ku" => "Kurd\u{00ee}", "kw" => "Kernewek", "ky" => "\u{041a}\u{044b}\u{0440}\u{0433}\u{044b}\u{0437}\u{0447}\u{0430}", "lag" => "K\u{0268}laangi", "lb" => "L\u{00eb}tzebuergesch", "lg" => "Luganda", "lkt" => "Lak\u{021f}\u{00f3}l\u{02bc}iyapi", "ln" => "Ling\u{00e1}la", "lo" => "\u{0ea5}\u{0eb2}\u{0ea7}", "lrc" => "\u{0644}\u{06ca}\u{0631}\u{06cc} \u{0634}\u{0648}\u{0645}\u{0627}\u{0644}\u{06cc}", "lt" => "Lietuvi\u{0173}", "lu" => "Tshiluba", "luo" => "Dholuo", "luy" => "Luluhia", "lv" => "Latvie\u{0161}u", "mai" => "\u{092e}\u{0948}\u{0925}\u{093f}\u{0932}\u{0940}", "mas" => "Maa", "mer" => "K\u{0129}m\u{0129}r\u{0169}", "mfe" => "Kreol morisien", "mg" => "Malagasy", "mgh" => "Makua", "mgo" => "Meta\u{02bc}", "mi" => "Te reo m\u{0101}ori", "mk" => "\u{041c}\u{0430}\u{043a}\u{0435}\u{0434}\u{043e}\u{043d}\u{0441}\u{043a}\u{0438}", "ml" => "\u{0d2e}\u{0d32}\u{0d2f}\u{0d3e}\u{0d33}\u{0d02}", "mn" => "\u{041c}\u{043e}\u{043d}\u{0433}\u{043e}\u{043b}", "mni" => "\u{09ae}\u{09c8}\u{09a4}\u{09c8}\u{09b2}\u{09cb}\u{09a8}\u{09cd}", "mr" => "\u{092e}\u{0930}\u{093e}\u{0920}\u{0940}", "ms" => "Melayu", "mt" => "Malti", "mua" => "Munda\u{014b}", "my" => "\u{1019}\u{103c}\u{1014}\u{103a}\u{1019}\u{102c}", "mzn" => "\u{0645}\u{0627}\u{0632}\u{0631}\u{0648}\u{0646}\u{06cc}", "naq" => "Khoekhoegowab", "nd" => "Isindebele", "nds" => "Neddersass\u{2019}sch", "ne" => "\u{0928}\u{0947}\u{092a}\u{093e}\u{0932}\u{0940}", "nl" => "Nederlands", "nmg" => "Kwasio", "nnh" => "Shw\u{00f3}\u{014b}\u{00f2} ngiemb\u{0254}\u{0254}n", "no" => "Norsk", "nus" => "Thok nath", "nyn" => "Runyankore", "om" => "Oromoo", "or" => "\u{0b13}\u{0b21}\u{0b3c}\u{0b3f}\u{0b06}", "os" => "\u{0418}\u{0440}\u{043e}\u{043d}", "pa" => "\u{0a2a}\u{0a70}\u{0a1c}\u{0a3e}\u{0a2c}\u{0a40}", "pcm" => "Naij\u{00ed}ri\u{00e1} p\u{00ed}jin", "pl" => "Polski", "ps" => "\u{067e}\u{069a}\u{062a}\u{0648}", "pt" => "Portugu\u{00ea}s", "qu" => "Runasimi", "rm" => "Rumantsch", "rn" => "Ikirundi", "ro" => "Rom\u{00e2}n\u{0103}", "rof" => "Kihorombo", "ru" => "\u{0420}\u{0443}\u{0441}\u{0441}\u{043a}\u{0438}\u{0439}", "rw" => "Kinyarwanda", "rwk" => "Kiruwa", "sa" => "\u{0938}\u{0902}\u{0938}\u{094d}\u{0915}\u{0943}\u{0924} \u{092d}\u{093e}\u{0937}\u{093e}", "sah" => "\u{0421}\u{0430}\u{0445}\u{0430} \u{0442}\u{044b}\u{043b}\u{0430}", "saq" => "Kisampur", "sat" => "\u{1c65}\u{1c5f}\u{1c71}\u{1c5b}\u{1c5f}\u{1c72}\u{1c64}", "sbp" => "Ishisangu", "sc" => "Sardu", "sd" => "\u{0633}\u{0646}\u{068c}\u{064a}", "se" => "Davvis\u{00e1}megiella", "seh" => "Sena", "ses" => "Koyraboro senni", "sg" => "S\u{00e4}ng\u{00f6}", "shi" => "\u{2d5c}\u{2d30}\u{2d5b}\u{2d4d}\u{2d43}\u{2d49}\u{2d5c}", "si" => "\u{0dc3}\u{0dd2}\u{0d82}\u{0dc4}\u{0dbd}", "sk" => "Sloven\u{010d}ina", "sl" => "Sloven\u{0161}\u{010d}ina", "smn" => "Anar\u{00e2}\u{0161}kiel\u{00e2}", "sn" => "Chishona", "so" => "Soomaali", "sq" => "Shqip", "sr" => "\u{0421}\u{0440}\u{043f}\u{0441}\u{043a}\u{0438}", "su" => "Basa sunda", "sv" => "Svenska", "sw" => "Kiswahili", "ta" => "\u{0ba4}\u{0bae}\u{0bbf}\u{0bb4}\u{0bcd}", "te" => "\u{0c24}\u{0c46}\u{0c32}\u{0c41}\u{0c17}\u{0c41}", "teo" => "Kiteso", "tg" => "\u{0422}\u{043e}\u{04b7}\u{0438}\u{043a}\u{04e3}", "th" => "\u{0e44}\u{0e17}\u{0e22}", "ti" => "\u{1275}\u{130d}\u{122d}\u{129b}", "tk" => "T\u{00fc}rkmen dili", "to" => "Lea fakatonga", "tr" => "T\u{00fc}rk\u{00e7}e", "tt" => "\u{0422}\u{0430}\u{0442}\u{0430}\u{0440}", "twq" => "Tasawaq senni", "tzm" => "Tamazi\u{0263}t n la\u{1e6d}la\u{1e63}", "ug" => "\u{0626}\u{06c7}\u{064a}\u{063a}\u{06c7}\u{0631}\u{0686}\u{06d5}", "uk" => "\u{0423}\u{043a}\u{0440}\u{0430}\u{0457}\u{043d}\u{0441}\u{044c}\u{043a}\u{0430}", "ur" => "\u{0627}\u{0631}\u{062f}\u{0648}", "uz" => "O\u{2018}zbek", "vai" => "\u{a559}\u{a524}", "vi" => "Ti\u{1ebf}ng vi\u{1ec7}t", "vun" => "Kyivunjo", "wae" => "Walser", "wo" => "Wolof", "xh" => "Isixhosa", "xog" => "Olusoga", "yav" => "Nuasue", "yi" => "\u{05d9}\u{05d9}\u{05b4}\u{05d3}\u{05d9}\u{05e9}", "yo" => "\u{00c8}d\u{00e8} yor\u{00f9}b\u{00e1}", "yrl" => "Nhe\u{1ebd}gatu", "yue" => "\u{4e2d}\u{6587} (\u{7cb5}\u{8a9e})", "zgh" => "\u{2d5c}\u{2d30}\u{2d4e}\u{2d30}\u{2d63}\u{2d49}\u{2d56}\u{2d5c}", "zh" => "\u{666e}\u{901a}\u{8bdd}", "zu" => "Isizulu");
    $languageCodes = array("Ch'ti / Picard" => "pd", "Afrikaans" => "af", "Aghem" => "agq", "Akan" => "ak", "\u{12a0}\u{121b}\u{122d}\u{129b}" => "am", "\u{0627}\u{0644}\u{0639}\u{0631}\u{0628}\u{064a}\u{0629}" => "ar", "\u{0985}\u{09b8}\u{09ae}\u{09c0}\u{09af}\u{09bc}\u{09be}" => "as", "Kipare" => "asa", "Asturianu" => "ast", "Az\u{0259}rbaycan" => "az", "\u{0181}\u{00e0}s\u{00e0}a" => "bas", "\u{0411}\u{0435}\u{043b}\u{0430}\u{0440}\u{0443}\u{0441}\u{043a}\u{0430}\u{044f}" => "be", "Ichibemba" => "bem", "Hibena" => "bez", "\u{0411}\u{044a}\u{043b}\u{0433}\u{0430}\u{0440}\u{0441}\u{043a}\u{0438}" => "bg", "Bamanakan" => "bm", "\u{09ac}\u{09be}\u{0982}\u{09b2}\u{09be}" => "bn", "\u{0f56}\u{0f7c}\u{0f51}\u{0f0b}\u{0f66}\u{0f90}\u{0f51}\u{0f0b}" => "bo", "Brezhoneg" => "br", "\u{092c}\u{0930}\u{2019}" => "brx", "Bosanski" => "bs", "Catal\u{00e0}" => "ca", "\u{d804}\u{dd0c}\u{d804}\u{dd0b}\u{d804}\u{dd34}\u{d804}\u{dd1f}\u{d804}\u{dd33}\u{d804}\u{dd26}" => "ccp", "\u{041d}\u{043e}\u{0445}\u{0447}\u{0438}\u{0439}\u{043d}" => "ce", "Binisaya" => "ceb", "Rukiga" => "cgg", "\u{13e3}\u{ab83}\u{ab79}" => "chr", "\u{06a9}\u{0648}\u{0631}\u{062f}\u{06cc}\u{06cc} \u{0646}\u{0627}\u{0648}\u{06d5}\u{0646}\u{062f}\u{06cc}" => "ckb", "\u{010c}e\u{0161}tina" => "cs", "Cymraeg" => "cy", "Dansk" => "da", "Kitaita" => "dav", "Deutsch" => "de", "Zarmaciine" => "dje", "\u{0921}\u{094b}\u{0917}\u{0930}\u{0940}" => "doi", "Dolnoserb\u{0161}\u{0107}ina" => "dsb", "Du\u{00e1}l\u{00e1}" => "dua", "Joola" => "dyo", "\u{0f62}\u{0fab}\u{0f7c}\u{0f44}\u{0f0b}\u{0f41}" => "dz", "K\u{0129}embu" => "ebu", "E\u{028b}egbe" => "ee", "\u{0395}\u{03bb}\u{03bb}\u{03b7}\u{03bd}\u{03b9}\u{03ba}\u{03ac}" => "el", "English" => "en", "Esperanto" => "eo", "Espa\u{00f1}ol" => "es", "Eesti" => "et", "Euskara" => "eu", "Ewondo" => "ewo", "\u{0641}\u{0627}\u{0631}\u{0633}\u{06cc}" => "fa", "Pulaar" => "ff", "Suomi" => "fi", "Filipino" => "fil", "F\u{00f8}royskt" => "fo", "Fran\u{00e7}ais" => "fr", "Furlan" => "fur", "Frysk" => "fy", "Gaeilge" => "ga", "G\u{00e0}idhlig" => "gd", "Galego" => "gl", "Schwiizert\u{00fc}\u{00fc}tsch" => "gsw", "\u{0a97}\u{0ac1}\u{0a9c}\u{0ab0}\u{0abe}\u{0aa4}\u{0ac0}" => "gu", "Ekegusii" => "guz", "Gaelg" => "gv", "Hausa" => "ha", "\u{02bb}\u{014d}lelo hawai\u{02bb}i" => "haw", "\u{05e2}\u{05d1}\u{05e8}\u{05d9}\u{05ea}" => "he", "\u{0939}\u{093f}\u{0928}\u{094d}\u{0926}\u{0940}" => "hi", "Hrvatski" => "hr", "Hornjoserb\u{0161}\u{0107}ina" => "hsb", "Magyar" => "hu", "\u{0540}\u{0561}\u{0575}\u{0565}\u{0580}\u{0565}\u{0576}" => "hy", "Interlingua" => "ia", "Indonesia" => "id", "Igbo" => "ig", "\u{a188}\u{a320}\u{a259}" => "ii", "\u{00cd}slenska" => "is", "Italiano" => "it", "\u{65e5}\u{672c}\u{8a9e}" => "ja", "Nda\u{a78c}a" => "jgo", "Kimachame" => "jmc", "Jawa" => "jv", "\u{10e5}\u{10d0}\u{10e0}\u{10d7}\u{10e3}\u{10da}\u{10d8}" => "ka", "Taqbaylit" => "kab", "Kikamba" => "kam", "Chimakonde" => "kde", "Kabuverdianu" => "kea", "Kanhg\u{00e1}g" => "kgp", "Koyra ciini" => "khq", "Gikuyu" => "ki", "\u{049a}\u{0430}\u{0437}\u{0430}\u{049b} \u{0442}\u{0456}\u{043b}\u{0456}" => "kk", "Kak\u{0254}" => "kkj", "Kalaallisut" => "kl", "Kalenjin" => "kln", "\u{1781}\u{17d2}\u{1798}\u{17c2}\u{179a}" => "km", "\u{0c95}\u{0ca8}\u{0ccd}\u{0ca8}\u{0ca1}" => "kn", "\u{d55c}\u{ad6d}\u{c5b4}" => "ko", "\u{0915}\u{094b}\u{0902}\u{0915}\u{0923}\u{0940}" => "kok", "\u{06a9}\u{0672}\u{0634}\u{064f}\u{0631}" => "ks", "Kishambaa" => "ksb", "Rikpa" => "ksf", "K\u{00f6}lsch" => "ksh", "Kurd\u{00ee}" => "ku", "Kernewek" => "kw", "\u{041a}\u{044b}\u{0440}\u{0433}\u{044b}\u{0437}\u{0447}\u{0430}" => "ky", "K\u{0268}laangi" => "lag", "L\u{00eb}tzebuergesch" => "lb", "Luganda" => "lg", "Lak\u{021f}\u{00f3}l\u{02bc}iyapi" => "lkt", "Ling\u{00e1}la" => "ln", "\u{0ea5}\u{0eb2}\u{0ea7}" => "lo", "\u{0644}\u{06ca}\u{0631}\u{06cc} \u{0634}\u{0648}\u{0645}\u{0627}\u{0644}\u{06cc}" => "lrc", "Lietuvi\u{0173}" => "lt", "Tshiluba" => "lu", "Dholuo" => "luo", "Luluhia" => "luy", "Latvie\u{0161}u" => "lv", "\u{092e}\u{0948}\u{0925}\u{093f}\u{0932}\u{0940}" => "mai", "Maa" => "mas", "K\u{0129}m\u{0129}r\u{0169}" => "mer", "Kreol morisien" => "mfe", "Malagasy" => "mg", "Makua" => "mgh", "Meta\u{02bc}" => "mgo", "Te reo m\u{0101}ori" => "mi", "\u{041c}\u{0430}\u{043a}\u{0435}\u{0434}\u{043e}\u{043d}\u{0441}\u{043a}\u{0438}" => "mk", "\u{0d2e}\u{0d32}\u{0d2f}\u{0d3e}\u{0d33}\u{0d02}" => "ml", "\u{041c}\u{043e}\u{043d}\u{0433}\u{043e}\u{043b}" => "mn", "\u{09ae}\u{09c8}\u{09a4}\u{09c8}\u{09b2}\u{09cb}\u{09a8}\u{09cd}" => "mni", "\u{092e}\u{0930}\u{093e}\u{0920}\u{0940}" => "mr", "Melayu" => "ms", "Malti" => "mt", "Munda\u{014b}" => "mua", "\u{1019}\u{103c}\u{1014}\u{103a}\u{1019}\u{102c}" => "my", "\u{0645}\u{0627}\u{0632}\u{0631}\u{0648}\u{0646}\u{06cc}" => "mzn", "Khoekhoegowab" => "naq", "Isindebele" => "nd", "Neddersass\u{2019}sch" => "nds", "\u{0928}\u{0947}\u{092a}\u{093e}\u{0932}\u{0940}" => "ne", "Nederlands" => "nl", "Kwasio" => "nmg", "Shw\u{00f3}\u{014b}\u{00f2} ngiemb\u{0254}\u{0254}n" => "nnh", "Norsk" => "no", "Thok nath" => "nus", "Runyankore" => "nyn", "Oromoo" => "om", "\u{0b13}\u{0b21}\u{0b3c}\u{0b3f}\u{0b06}" => "or", "\u{0418}\u{0440}\u{043e}\u{043d}" => "os", "\u{0a2a}\u{0a70}\u{0a1c}\u{0a3e}\u{0a2c}\u{0a40}" => "pa", "Naij\u{00ed}ri\u{00e1} p\u{00ed}jin" => "pcm", "Polski" => "pl", "\u{067e}\u{069a}\u{062a}\u{0648}" => "ps", "Portugu\u{00ea}s" => "pt", "Runasimi" => "qu", "Rumantsch" => "rm", "Ikirundi" => "rn", "Rom\u{00e2}n\u{0103}" => "ro", "Kihorombo" => "rof", "\u{0420}\u{0443}\u{0441}\u{0441}\u{043a}\u{0438}\u{0439}" => "ru", "Kinyarwanda" => "rw", "Kiruwa" => "rwk", "\u{0938}\u{0902}\u{0938}\u{094d}\u{0915}\u{0943}\u{0924} \u{092d}\u{093e}\u{0937}\u{093e}" => "sa", "\u{0421}\u{0430}\u{0445}\u{0430} \u{0442}\u{044b}\u{043b}\u{0430}" => "sah", "Kisampur" => "saq", "\u{1c65}\u{1c5f}\u{1c71}\u{1c5b}\u{1c5f}\u{1c72}\u{1c64}" => "sat", "Ishisangu" => "sbp", "Sardu" => "sc", "\u{0633}\u{0646}\u{068c}\u{064a}" => "sd", "Davvis\u{00e1}megiella" => "se", "Sena" => "seh", "Koyraboro senni" => "ses", "S\u{00e4}ng\u{00f6}" => "sg", "\u{2d5c}\u{2d30}\u{2d5b}\u{2d4d}\u{2d43}\u{2d49}\u{2d5c}" => "shi", "\u{0dc3}\u{0dd2}\u{0d82}\u{0dc4}\u{0dbd}" => "si", "Sloven\u{010d}ina" => "sk", "Sloven\u{0161}\u{010d}ina" => "sl", "Anar\u{00e2}\u{0161}kiel\u{00e2}" => "smn", "Chishona" => "sn", "Soomaali" => "so", "Shqip" => "sq", "\u{0421}\u{0440}\u{043f}\u{0441}\u{043a}\u{0438}" => "sr", "Basa sunda" => "su", "Svenska" => "sv", "Kiswahili" => "sw", "\u{0ba4}\u{0bae}\u{0bbf}\u{0bb4}\u{0bcd}" => "ta", "\u{0c24}\u{0c46}\u{0c32}\u{0c41}\u{0c17}\u{0c41}" => "te", "Kiteso" => "teo", "\u{0422}\u{043e}\u{04b7}\u{0438}\u{043a}\u{04e3}" => "tg", "\u{0e44}\u{0e17}\u{0e22}" => "th", "\u{1275}\u{130d}\u{122d}\u{129b}" => "ti", "T\u{00fc}rkmen dili" => "tk", "Lea fakatonga" => "to", "T\u{00fc}rk\u{00e7}e" => "tr", "\u{0422}\u{0430}\u{0442}\u{0430}\u{0440}" => "tt", "Tasawaq senni" => "twq", "Tamazi\u{0263}t n la\u{1e6d}la\u{1e63}" => "tzm", "\u{0626}\u{06c7}\u{064a}\u{063a}\u{06c7}\u{0631}\u{0686}\u{06d5}" => "ug", "\u{0423}\u{043a}\u{0440}\u{0430}\u{0457}\u{043d}\u{0441}\u{044c}\u{043a}\u{0430}" => "uk", "\u{0627}\u{0631}\u{062f}\u{0648}" => "ur", "O\u{2018}zbek" => "uz", "\u{a559}\u{a524}" => "vai", "Ti\u{1ebf}ng vi\u{1ec7}t" => "vi", "Kyivunjo" => "vun", "Walser" => "wae", "Wolof" => "wo", "Isixhosa" => "xh", "Olusoga" => "xog", "Nuasue" => "yav", "\u{05d9}\u{05d9}\u{05b4}\u{05d3}\u{05d9}\u{05e9}" => "yi", "\u{00c8}d\u{00e8} yor\u{00f9}b\u{00e1}" => "yo", "Nhe\u{1ebd}gatu" => "yrl", "\u{7cb5}\u{8a9e}" => "yue", "\u{4e2d}\u{6587} (\u{7cb5}\u{8a9e})" => "yue", "\u{2d5c}\u{2d30}\u{2d4e}\u{2d30}\u{2d63}\u{2d49}\u{2d56}\u{2d5c}" => "zgh", "\u{4e2d}\u{6587}" => "zh", "\u{666e}\u{901a}\u{8bdd}" => "zh", "Isizulu" => "zu");


    /**
     * Tests if a string starts with a substring
     */
    function startsWith( $string, $substring ) {
        $length = strlen( $substring );
        return substr( $string, 0, $length ) === $substring;
    }

    /**
        * Tests if a string ends with a substring
        */
    function endsWith( $string, $substring ) {
        $length = strlen( $substring );
        if( !$length ) {
            return true;
        }
        return substr( $string, -$length ) === $substring;
    }

    /**
        * Prepares the prefix for SQL table names (adds a "_" at the end if needed)
        */
    function setupTablePrefix() {
        global $tablePrefix;
        if (strlen($tablePrefix) > 0 && !endsWith($tablePrefix, "_")) $tablePrefix = $tablePrefix . "_";
    }

    /**
    * Check if the URL has the given arg
    */
    function hasArg( $name )
    {
        return isset($_GET[$name]);
    }
    
    /**
    * Gets an argument from the url
    */
    function getArg($name, $defaultValue = "")
    {
        global $contentInPost, $contentAsJson, $bodyContent;

        $decordedArg = "";

        // First, try from URL
        if ( hasArg( $name ) )
        {
            $decordedArg = rawurldecode ( $_GET[$name] );
        }
        
        if ($decordedArg == "") return $defaultValue;       

        return $decordedArg;
    }

    function checkArgs( $arglist )
    {
        global $reply;

        $ok = true;
        foreach( $arglist as $arg )
        {
            if ($arg == "")
            {
                $ok = false;
                break;
            }
        }
        if (!$ok)
        {
            $reply["message"] = "Invalid request, missing values";
            $reply["success"] = false;
        }
        return $ok;
    }

    function sqlRequest( $request, $message = "", $debug = false )
    {
        global $reply;

        if ($debug) $request->debugDumpParams();

        $ok = $request->execute();

        if (!$ok)
        {
            $reply["message"] = $rep->errorInfo()[2];
            $reply["success"] = false;
        }
        else if ($message != "")
        {
            $reply["message"] = $message;
            $reply["success"] = true;
        }
        
        return $ok;
    }

    function acceptReply($queryName)
    {
        global $reply;
        $reply["accepted"] = true;
        $reply["query"] = $queryName;
    }

    // === CACHE ===
    function getCache( $name ) {
        global $cacheTimeout, $__ROOT__;

        // Create the cache folder
        if (!is_dir($__ROOT__."/cache")) mkdir($__ROOT__."/cache", 0744);

        // Get file if it exists
        $cacheFile = "{$__ROOT__}/cache/{$name}";
        $content = "";
        $timedOut = true;

    clearstatcache();

        if (file_exists($cacheFile)) {
            $timedOut = time() - $cacheTimeout > filemtime($cacheFile);
            $cached = fopen($cacheFile, 'r');
            if ($cached !== false) {
                $content = fread($cached, filesize($cacheFile));
                fclose($cached);
            }
        }
        // If we don't have the file, return right now
        else {
            return "";
        }

        // If the cache have timed out, trigger an update
        if ($timedOut) {
            $url = "http://".$_SERVER['SERVER_NAME']."/updateCache.php?{$name}";
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'RxAPI/2.0 (PHP)');
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 100);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 100);
            curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
            curl_exec($curl);
            curl_close($curl);
        }

        return $content;
    }

    function saveCache( $name, $content ) {
        global $__ROOT__;

        // Create the cache folder
        if (!is_dir($__ROOT__."/cache")) mkdir($__ROOT__."/cache", 0744);

        // Get file
        $cacheFile = "{$__ROOT__}/cache/{$name}";

        // Cache the contents to a cache file
        $cached = fopen($cacheFile, 'w');
        if ($cached !== false) {
            fwrite($cached, $content);
            fclose($cached);
        }
    }

    // === GITHUB ===

    function ghRequest( $url ) {
        global $ghUsername;
        global $ghToken;

        $userAgent = 'RxAPI/2.0 (PHP)';

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_USERPWD, "{$ghUsername}:{$ghToken}");
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function ghGraphQL( $query ) {
        global $ghUsername;
        global $ghToken;

        $userAgent = 'RxAPI/2.0 (PHP)';

        $ch = curl_init( "https://api.github.com/graphql" );
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                "User-Agent: {$userAgent}",
                "Content-Type: application/json;charset=utf-8",
                "Authorization: bearer {$ghToken}"
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function ghBackers($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "ghBackers" );
            if ($cached != "") return (int)$cached;
        }

        global $ghUser;

        $query = <<<JSON
        query {
            organization(login: "$ghUser") {
                sponsors {
                    totalCount
                }
            }
        }
        JSON;
        $variables = '';

        $query = json_encode(['query' => $query, 'variables' => $variables]);

        $gh = ghGraphQL($query);
        $gh = json_decode($gh, true);

        $count = $gh["data"]["organization"]["sponsors"]["totalCount"];

        saveCache("ghBackers", $count);

        return $count;
    }

    function ghIncome($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "ghIncome" );
            if ($cached != "") return (int)$cached;
        }

        global $ghUser;

        $query = <<<JSON
        query {
            organization(login: "$ghUser") {
                monthlyEstimatedSponsorsIncomeInCents
            }
        }
        JSON;
        $variables = '';

        $query = json_encode(['query' => $query, 'variables' => $variables]);

        $gh = ghGraphQL($query);
        $gh = json_decode($gh, true);
        $fund = $gh["data"]["organization"]["monthlyEstimatedSponsorsIncomeInCents"] / 100;

        saveCache("ghIncome", $fund);

        return $fund;
    }

    // === PATREON ===

    function patreonRequest( $url ) {
        global $patreonToken;

        $userAgent = 'RxAPI/2.0 (PHP)';
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                "User-Agent: {$userAgent}",
                "Content-Type: application/json;charset=utf-8",
                "Authorization: bearer {$patreonToken}"
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function patreonBackers($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "patreonBackers" );
            if ($cached != "") return (int)$cached;
        }

        global $patreonToken;
        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);

            $count = $patreon["data"][0]["attributes"]["patron_count"];
            saveCache("patreonBackers", $count);

            return $count;
        };
        return 0;
    }

    function patreonIncome($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "patreonIncome" );
            if ($cached != "") return (int)$cached;
        }

        global $patreonToken;
        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            $fund = $patreon["data"][0]["attributes"]["pledge_sum"] / 100;
            saveCache("patreonIncome", $fund);
            return $fund;
        };
        return 0;
    }

    // === WORDPRESS MEMBERSHIP ===
    function wpRequest( $url ) {
        global $wpUsername;
        global $wpPassword;

        $userAgent = 'RxAPI/2.0 (PHP)';

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_USERPWD, "{$wpUsername}:{$wpPassword}");
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function wpBackers($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "wpBackers" );
            if ($cached != "") return (int)$cached;
        }

        global $wpUsername;
        global $wpPassword;

        if ($wpUsername == "" || $wpPassword == "") return 0;

        $count = 0;

        $members = wpRequest("https://rxlaboratory.org/wp-json/wp/v2/users?roles=subscriber,customer");
        $members = json_decode($members, true);

        // For each member, check the membership
        foreach( $members as $member ) {
            $id = $member['id'];
            $level = wpRequest("https://rxlaboratory.org/wp-json/pmpro/v1/get_membership_level_for_user?user_id={$id}");
            $level = json_decode($level, true);
            if ($level) {
                $enddate = (int)$level["enddate"];
                if ( $enddate == 0 || $enddate > time() ) $count++;
            }
        }

        saveCache("wpBackers", $count);
        return $count;
    }

    function wpIncome($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "wpIncome" );
            if ($cached != "") return (int)$cached;
        }

        global $wpUsername;
        global $wpPassword;

        if ($wpUsername == "" || $wpPassword == "") return 0;

        $fund = 0;

        $members = wpRequest("https://rxlaboratory.org/wp-json/wp/v2/users?roles=subscriber,customer");
        $members = json_decode($members, true);

        // For each member, check the membership
        foreach( $members as $member ) {
            $id = $member['id'];
            $level = wpRequest("https://rxlaboratory.org/wp-json/pmpro/v1/get_membership_level_for_user?user_id={$id}");
            
            $level = json_decode($level, true);
            if ($level) {
                $enddate = (int)$level["enddate"];
                if ( $enddate > 0 && $enddate < time() ) continue;

                $amount = (float)$level["billing_amount"];
                $cycle_num = (int)$level["cycle_number"];
                $cycle_period = $level["cycle_period"];
                if ($cycle_num == 0) continue;

                if ($cycle_period == "Day") {
                    $amount = (30 / $cycle_num) * $amount;
                }
                else if ($cycle_period == "Week") {
                    $amount = (4 / $cycle_num) * $amount;
                }
                else if ($cycle_period == "Month") {
                    $amount = $amount / $cycle_num;
                }
                else if ($cycle_period == "Year") {
                    $amount = $amount / (12 * $cycle_num);
                }

                $fund += $amount;
            }
        }
        saveCache("wpIncome", $fund);
        return $fund;
    }

    // === WOOCOMMERCE ===

    function wcRequest( $url ) {
        global $wcUsername;
        global $wcToken;
        global $wcProducts;

        $userAgent = 'RxAPI/2.0 (PHP)';

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_USERPWD, "{$wcUsername}:{$wcToken}");
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function wcBackers($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "wcBackers" );
            if ($cached != "") return (int)$cached;
        }

        global $wcToken;
        global $wcUsername;
        global $wcProducts;
        if ($wcToken != "" && $wcUsername != "") {
            // Get current month
            $d = new DateTime('first day of this month');
            $d = urlencode( $d->format('Y-m-d\TH:i:s') );
            $wc = wcRequest( "https://rxlaboratory.org/wp-json/wc/v3/orders?after={$d}&per_page=100" );
            $wc = json_decode($wc, true);
            $wcCount = 0;
            foreach ($wc as $order) {
                // Check the product
                if (count($wcProducts) > 0) {
                    foreach( $order["line_items"] as $item ) {
                        if($order["status"] != "processing" && $order["status"] != "completed" ) continue;
                        if (in_array($item["product_id"], $wcProducts)) {
                            $wcCount++;
                            break;
                        }
                    }
                }
                // add whole order
                else {
                    $wcCount++;
                }
            }

            saveCache("wcBackers", $wcCount);
            return $wcCount;
        }
        return 0;
    }

    function wcIncome($skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "wcIncome" );
            if ($cached != "") return (int)$cached;
        }

        global $wcToken;
        global $wcUsername;
        global $wcProducts;
        if ($wcToken != "" && $wcUsername != "") {
            // Get current month
            $d = new DateTime('first day of this month');
            $d = urlencode( $d->format('Y-m-d\TH:i:s') );
            $wc = wcRequest( "https://rxlaboratory.org/wp-json/wc/v3/orders?after={$d}&per_page=100" );
            $wc = json_decode($wc, true);
            $wcCount = 0;
            if (gettype($wc) == 'array')
                foreach ($wc as $order) {
                    if($order["status"] != "processing" && $order["status"] != "completed" ) continue;
                    // Check the product
                    if (count($wcProducts) > 0) {
                        foreach( $order["line_items"] as $item ) {
                            if (in_array($item["product_id"], $wcProducts)) {
                                $wcCount += (int)$item["subtotal"];
                                break;
                            }
                        }
                    }
                    // add whole order
                    else {
                        $wcCount += $wc["total"];
                    }
                }

            saveCache("wcIncome", $wcCount);
            return $wcCount;
        }
        return 0;
    }

    // === STATS ===
    function getStats($from, $to, $skipCache = false) {
        if (!$skipCache) {
            $cached = getCache( "getStats" );
            if ($cached != "") return json_decode($cached, true);
        }

        global $db, $statsTable, $languageNames;

        $rep = $db->prepare( "SELECT *
                FROM {$statsTable}
                WHERE {$statsTable}.`date` >= :from
                    AND {$statsTable}.`date` <= :to
                    ;"
                );
        $rep->bindValue(':from', $from, PDO::PARAM_STR);
        $rep->bindValue(':to', $to, PDO::PARAM_STR);
        $ok = sqlRequest( $rep, "Successful request." );

        // prepare results
        $winCount = 0;
        $macCount = 0;
        $linuxCount = 0;
        $userCount = 0;
        $winRatio = 0;
        $macRatio = 0;
        $linuxRatio = 0;
        $apps = array();
        $languageCount = 0;
        $languages = array();

        if ($ok)
        {
            $stats = array();

            while ($v = $rep->fetch()) {
                if($v['os'] == 'win') $winCount++;
                else if($v['os'] == 'mac') $macCount++;
                else if($v['os'] == 'linux') $linuxCount++;
                else continue;
                $userCount++;
                $app = array();
                $app['name'] = $v['appName'];
                if (!isset($apps[$app['name']])) {
                    $app["count"] = 1;
                    $app["ratio"] = 0;
                    $app["host"] = $v['host'];
                    $apps[$app['name']] = $app;
                }
                else {
                    $apps[$app['name']]["count"]++;
                }

                $lang = $v['languageCode'];
                if ($lang != 'unknown') {
                    $languageCount++;
                    if (!isset($languages[$lang]))
                    {
                        $language = array();
                        $language['code'] = $lang;
                        $language['name'] = $languageNames[$lang];
                        $language["count"] = 1;
                        $language["ratio"] = 0;
                        $languages[$lang] = $language;
                    }
                    else
                    {
                        $languages[$lang]['count']++;
                    }
                }
            }
            $rep->closeCursor();

            // ratio
            $allApps = array();
            foreach( $apps as $app ) {
                $app["ratio"] = round($app["count"] / $userCount * 100);
                $allApps[] = $app;
            }
            $winRatio = round($winCount / $userCount * 100);
            $macRatio = round($macCount / $userCount * 100);
            $linuxRatio = round($linuxCount / $userCount * 100);

            $allLanguages = array();
            foreach($languages as $language) {
                $language['ratio'] = round($language['count'] / $languageCount * 100);
                $allLanguages[] = $language;                
            }

            // sort apps
            usort($allApps, function($a, $b) {
                return $b["count"] - $a["count"];
            });

            // sort languages
            usort($allLanguages, function($a, $b) {
                return $b["count"] - $a["count"];
            });

            $stats['winCount'] = $winCount;
            $stats['winRatio'] = $winRatio;
            $stats['macCount'] = $macCount;
            $stats['macRatio'] = $macRatio;
            $stats['linuxCount'] = $linuxCount;
            $stats['linuxRatio'] = $linuxRatio;
            $stats['userCount'] = $userCount;
            $stats['apps'] = $allApps;
            $stats['languages'] = $allLanguages;

            saveCache("getStats", json_encode($stats));

            return $stats;
        }

        return false;
    }
    
?>