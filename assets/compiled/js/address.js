var text = "";
function province_select(province_id, district_id, municipality_id){
    var s1 = document.getElementById(province_id);
    var s2 = document.getElementById(district_id);
    
    s2.innerHTML = '<option value="none" disabled selected>Select District</option>';
    document.getElementById(municipality_id).innerHTML = '<option value="none" disabled selected>Select Municipality</option>';
    var optionArray;

    switch(s1.value){
        case "koshi": 
            optionArray = ["bhojpur","dhankuta","ilam","jhapa","khotang","morang","okhaldhunga","panchthar","sankhuwasabha","solukhumbu","sunsari","taplejung","terhathum","udayapur"];
        break;
        case "madhesh":
            optionArray = ["bara", "dhanusha", "mahottari", "parsa", "rautahat", "saptari", "sarlahi", "siraha"];
        break;
        case "bagmati":
            optionArray = ["bhaktapur","chitwan","dhading","dolakha","kathmandu","kavrepalanchok","lalitpur","makwanpur","nuwakot","ramechhap","rasuwa","sindhuli","sindhupalchok"];
        break;
        case "gandaki":
            optionArray = ["baglung", "gorkha", "kaski", "lamjung", "manang", "mustang", "myagdi", "nawalpur", "parbat", "syangja", "tanahun"];
        break;
        case "lumbini":
            optionArray = ["arghakhanchi", "banke", "bardiya", "dang", "gulmi", "kapilvastu", "nawalparasi", "palpa", "pyuthan", "rolpa", "rukum", "rupandehi"];
        break;
        case "karnali":
            optionArray = ["dailekh", "dolpa", "humla", "jajarkot", "jumla", "kalikot", "mugu", "rukum", "salyan", "surkhet"];
        break;
        case "sudhur_paschim":
            optionArray = ["achham", "baitadi", "bajhang", "bajura", "dadeldhura", "darchula", "doti", "kailali", "kanchanpur"];
        break;
    }

    for(var count in optionArray){
        var vlu = optionArray[count];
        var opt = document.createElement("option");

        opt.value = vlu;
        opt.innerHTML = vlu.charAt(0).toUpperCase() + vlu.slice(1);
        s2.options.add(opt);
    }
}

function district_all(district_id){
    var s1 = document.getElementById(district_id);

    s1.innerHTML = '<option value="none" disabled selected>Select District</option>';
    var optionArray = [
        "achham", "arghakhanchi", "baglung", "baitadi", "bajhang", "bajura", "banka", "bardiya", 
        "bara", "bhaktapur", "bhojpur", "chitwan", "dadeldhura", "dailekh", "darchula", "dhading", 
        "dhankuta", "dhanusha", "dolakha", "dolpa", "doti", "gorkha", "gulmi", "humla", "ilam", 
        "jajarkot", "jhapa", "jumla", "kalikot", "kailali", "kanchanpur", "kapilvastu", "kaski", 
        "kathmandu", "kavrepalanchok", "khotang", "lamjung", "lalitpur", "mahottari", "makwanpur", 
        "manang", "morang", "mugu", "mustang", "myagdi", "nawalparasi", "nawalpur", "nuwakot", 
        "okhaldhunga", "palpa", "panchthar", "parbat", "parsa", "pyuthan", "ramechhap", "rasuwa", 
        "rautahat", "rolpa", "rukum", "rupandehi", "salyan", "sankhuwasabha", "saptari", "sarlahi", 
        "sindhuli", "sindhupalchok", "siraha", "solukhumbu", "sunari", "surkhet", "syangja", 
        "tanahun", "taplejung", "terhathum", "udayapur"
    ];

    for(var count in optionArray){
        var vlu = optionArray[count];
        var opt = document.createElement("option");

        opt.value = vlu;
        opt.innerHTML = vlu.charAt(0).toUpperCase() + vlu.slice(1);
        s1.options.add(opt);
    }
}

function district_select(district_id, municipality_id){
    var s1 = document.getElementById(district_id);
    var s2 = document.getElementById(municipality_id);

    s2.innerHTML = '<option value="none" disabled selected>Select Municipality</option>';
    var optionArray;

    switch(s1.value){
        case "bhojpur": 
            optionArray = ["aamchok", "arun_aunpalika", "bhojpur", "hatuwagadhi", "pauwadungma", "ramprasad_rai", "salpasilichho", "shadanand", "tyamke_maiyunm"];
            break;
        case "dhankuta": 
            optionArray = ["chaubise", "chhathar_jorpati", "dhankuta", "khalsa_chhintang_sahidbhumi", "mahalaxmi", "pakhribas", "sangurigadhi"];
            break;
        case "ilam": 
            optionArray = ["chulachuli", "deumai", "ilam", "mai", "mai_jogmai", "mangsebung", "phakphokthum", "rong", "sandakpur", "suryodaya"];
            break;
        case "jhapa": 
            optionArray = ["arjundhara", "barhadashi", "bhadrapur", "birtamod", "buddhashanti", "damak", "gauradaha", "gauriganj", "haldibari", "jhapa", "kachankawal", "kamal", "kankai", "mechinagar", "shivasatakshi"];
            break;
        case "khotang": 
            optionArray = ["aiselukharka", "barahpokhari", "diktel_rupakot_majhuwagadhi", "diprung", "halesi_tuwachung", "jantedhunga", "kepilasgadhi", "khotehang", "rawabesi", "sakela"];
            break;
        case "morang": 
            optionArray = ["belbari", "biratnagar", "budhiganga", "dhanpalthan", "gramthan", "jahada", "kanepokhari", "katahari", "kerabari", "letang_bhogateni", "miklajung", "pathari_sanischare", "rangueli", "ratuwamai", "sunawarshi", "sundar_haraicha"];
            break;
        case "okhaldhunga": 
            optionArray = ["champadevi", "chisankhugadhi", "khijidemba", "likhu", "manebhanjyang", "molung", "siddhicharan", "sunkoshi"];
            break;
        case "panchthar": 
            optionArray = ["hilihang", "kummayak", "miklajung", "phalelung", "phalgunanda", "phidim", "tumbewa", "yangawarak"];
            break;
        case "sankhuwasabha": 
            optionArray = ["bhot_khola", "chainpur", "chichila", "dharmaDevi", "khandbari", "madi", "makalu", "panchkhapan", "sabhapokhari", "silingchong"];
            break;
        case "solukhumbu": 
            optionArray = ["dudhkoshi", "dudhakaushika", "khumbu_pasanglhamu", "likhu_pike", "maha_kulung", "necha_salyan", "solududhkunda", "sotang"];
            break;
        case "sunsari": 
            optionArray = ["barahachhetra", "barju", "bhokraha", "dharan", "dewanganj", "duhabi", "gadhi", "harinagara", "inaruwa", "itahari", "koshi", "ramdhuni"];
            break;
        case "taplejung": 
            optionArray = ["aathrai_tribeni", "maiwakhola", "meringden", "mikkwakhola", "pathibhara_yangwarak", "phaktanglung", "phungling", "sidingwa", "sirijangha"];
            break;
        case "terhathum": 
            optionArray = ["aathrai_tribeni", "maiwakhola", "meringden", "mikwakhola", "pathivara_yangwarak", "phaktanglung", "phungling_municipality", "sidingba", "sirijangha"];
            break;
        case "udayapur": 
            optionArray = ["belaka", "chaudandigadhi", "katari", "limchungbung", "rautamai", "tapli", "triyuga", "udayapurgadhi"];
            break;

        // madhesh pradesh
        case "sarlahi": 
            optionArray = ["bagmati", "balara", "barahathawa", "basbariya", "bishnu", "bramhapuri", "chandranagar", "chakraghatta", "dhankaul", "godaita", "hariwan", "haripur", "haripurwa", "ishworpur", "kabilasi", "kaudena", "lalbandi", "malangawa", "parsa", "ramnagar"];
            break;
        case "dhanusha":
            optionArray = ["aaurahi", "bateshwor", "bideha", "chhireshwornath", "dhanauji", "dhanusadham", "ganeshman_charnath", "hansapur", "janakpurdham", "janaknandani", "kamala", "lakshminiya", "mithila", "mithila_bihari", "mukhiyapatti_musarmiya", "nagarain", "sahidnagar", "sabaila"];
            break;
        case "bara":
            optionArray = ["adarshkotwal", "baragadhi", "bishrampur", "devtal", "jitpur_simara", "kalaiya", "karaiyamai", "kolhabi", "mahagadhimai", "nijgadh", "pacharauta", "parwanipur", "pheta", "prasauni", "simraungadh", "suwarna"];
            break;
        case "rautahat":
            optionArray = ["baudhimai", "brindaban", "chandrapur", "dewahhi_gonahi", "durga_bhagwati", "gadhimai", "garuda", "gaur", "gujara", "ishanath", "katahariya", "madhav_narayan", "maulapur", "paroha", "phatuwa_bijayapur", "rajdevi", "rajpur", "yemunamai"];
            break;
        case "saptari":
            optionArray = ["agnisair_krishna_savaran", "balan_bihul", "bode_barsain", "chhinnamasta", "dakneshwori", "hanumannagar_kankalini", "kanchanrup", "khadak", "mahadeva", "rajbiraj", "rajgadh", "rupani", "saptakoshi", "shambhunath", "surunga", "tilathi_koiladi", "tirahut", "bishnupur"];
            break;
        case "siraha":
            optionArray = ["arnama", "aurahi", "bariyarpatti", "bhagawanpur", "bishnupur", "dhangadhimai", "golbazar", "kalyanpur", "karjanha", "lahan", "laxmipur_patari", "mirchaiya", "naraha", "nawarajpur", "sakhuwanankarkatti", "siraha", "sukhipur"];
            break;
        case "mahottari":
            optionArray = ["aurahi", "balwa", "bardibas", "bhangaha", "ekdanra", "gaushala", "jaleswor", "loharpatti", "mahottari", "manra_siswa", "matihani", "pipra", "ramgopalpur", "samsi", "sonama"];
            break;
        case "parsa":
            optionArray = ["bahudarmai", "bindabasini", "birgunj", "chhipaharmai", "dhobini", "jagarnathpur", "jirabhawani", "kalikamai", "pakaha_mainpur", "parsagadhi", "paterwa_sugauli", "pokhariya", "sakhuwa_prasauni", "thori"];
            break;

        // bagmati pradesh
        case "sindhuli" :
            optionArray = ["dudhouli", "ghanglekh", "golanjor", "hariharpurgadhi", "kamalamai", "marin", "phikkal", "sunkoshi", "tinpatan"];   
            break;
        case "ramechhap" :
            optionArray = ["doramba", "gokulganga", "khadadevi", "likhu_tamakoshi", "manthali", "ramechhap", "sunapati", "umakunda"];    
            break;
        case "dolakha" : 
            optionArray = ["baiteshwor", "bigu", "bhimeshwor", "gaurishankar", "jiri", "kalinchok", "melung", "sailung", "tamakoshi"];
            break;
        case "bhaktapur" :
            optionArray = ["bhaktapur", "changunarayan", "madhyapur_thimi", "suryabinayak"];    
            break;
        case "dhading" :
            optionArray = ["benighat_rorang", "dhunibesi", "gajuri", "galchi", "gangajamuna", "jwalamukhi", "khaniyabash", "netrawati_dabjong", "nilakantha", "rubi_valley", "siddhalek", "thakre", "tripura_sundari"];    
            break;
        case "kathmandu" :
            optionArray = ["budhanilakantha", "chandragiri", "dakshinkali", "gokarneshwor", "kageshwori_manahora", "kathmandu", "kirtipur", "nagarjun", "shankharapur", "tarakeshwor", "tokha"];    
            break;
        case "kavrepalanchok" :
            optionArray = ["banepa", "bethanchowk", "bhumlu", "chaurideurali", "dhulikhel", "khanikhola", "mahabharat", "mandandeupur", "namobuddha", "panchkhal", "panauti", "roshi", "temal"];    
            break;
        case "lalitpur" :
            optionArray = ["bagmati", "godawari", "konjyosom", "lalitpur", "mahalaxmi", "mahankal"];    
            break;
        case "nuwakot":
            optionArray = ["belkotgadhi", "bidur", "dupcheshwar", "kakani", "kispang", "likhu", "myagang", "panchakanya", "shivapuri", "suryagadhi", "tadi", "tarkeshwar"];    
            break;
        case "rasuwa" :
            optionArray = ["amachodingmo", "gosaikunda", "kalika", "naukunda", "uttargaya"];    
            break;
        case "sindhupalchok" :
            optionArray = ["balefi", "barhabise", "bhotekoshi", "chautara_sangachokGadhi", "helambu", "indrawati", "jugal", "lisangkhu_pakhar", "melamchi", "panchpokhari_thangpal", "sunkoshi", "tripurasundari"];    
            break;
        case "chitwan" :
            optionArray = ["bharatpur", "ichchhyakamana", "kalika", "khairahani", "madi", "rapti", "ratnanagar"];    
            break;
        case "makwanpur" :
            optionArray = ["bagmati", "bakaiya", "bhimphedi", "hetauda", "indrasarowar", "kailash", "makawanpurgadhi", "manahari", "raksirang", "thaha"];    
            break;

        // gandaki pradesh
            case "baglung" : 
            optionArray = ["baglung", "badigad", "bareng", "dhorpatan", "galkot", "jaimuni", "kanthekhola", "nisikhola", "taman_khola", "tara_khola"];
            break;
        case "gorkha" :
            optionArray = ["aarughat", "ajirkot", "bhimsenthapa", "barpak_sulikot", "chum_nubri", "dharche", "gandaki", "gorkha", "palungtar", "sahid_lakhan", "siranchok"];
            break;
        case "kaski" :
            optionArray = ["annapurna", "madi", "machhapuchchhre", "pokhara", "rupa"];
            break;
        case "lamjung" :
            optionArray = ["besishahar", "dordi", "dudhpokhari", "kwholasothar", "madhyaNepal", "marsyangdi", "rainas", "sundarbazar"];
            break;
        case "manang" :
            optionArray = ["chame", "manang_ingshyang", "narpa_bhumi", "narshon"];
            break;
        case "mustang" :
            optionArray = ["gharapjhong", "lo_ghekar_damodarkunda", "lomanthang", "thasang", "waragung_muktikhsetra"];
            break;
        case "myagdi" :
            optionArray = ["annapurna", "beni", "dhaulagiri", "mangala", "malika", "raghuganga"];
            break;
        case "nawalpur" :
            optionArray = ["baudeekali", "binayee_tribeni", "bulingtar", "devchuli", "gaidakot", "hupsekot", "kawasoti", "madhyabindu"];
            break;
        case "parbat":
            optionArray = ["bihadi", "jaljala", "kushma", "mahashila", "modi", "painyu", "phalebas"];
            break;
        case "syangja" :
            optionArray = ["aandhikhola", "arjunchaupari", "bhirkot", "biruwa", "chapakot", "galyang", "harinas", "kaligandagi", "phedikhola", "putalibazar", "waling"];
            break;
        case "tanahun" :
            optionArray = ["anbukhaireni", "bandipur", "bhanu", "bhimad", "devghat", "ghiring", "myagde", "rhishing", "shuklagandaki", "byas"];
            break;

        // lumbini pradesh
        case "kapilvastu" : 
            optionArray = ["banganga", "bijayanagar", "buddhabhumi", "kapilbastu", "krishnanagar", "mayadevi", "maharajgunj", "suddhodhan", "shivaraj", "yashodhara"];
            break;
        case "nawalparasi" : 
            optionArray = ["bardaghat", "palhi_nandan", "pratappur", "ramgram", "sarawal", "susta", "sunwal"];
            break;
        case "rupandehi" : 
            optionArray = ["butwal", "devdaha", "gaidahawa", "kanchan", "kotahimai", "lumbini_sanskritik", "marchawari", "mayadevi", "omsatiya", "sainamaina", "sammarimai", "sudhdhodhan", "siyari", "tillotama"];
            break;
        case "arghakhanchi" : 
            optionArray = ["bhumekasthan", "chhatradev", "malarani", "panini", "sandhikharka", "sitganga"];
            break;
        case "gulmi" :
            optionArray = ["chandrakot", "chatrakot", "dhurkot", "gulmidarbar", "isma", "kaligandaki", "madane", "malika", "musikot", "resunga", "rurukshetra", "satyawati"];
            break;
        case "palpa" : 
            optionArray = ["bagnaskali", "mathagadhi", "nisdi", "purbakhola", "rambha", "rainadevi_chhahara", "rampur", "ribdikot", "tinau"];
            break;
        case "dang" : 
            optionArray = ["babai", "banglachuli", "dangisharan", "gadhawa", "ghorahi", "lamahi", "rapti", "rajpur", "shantinagar", "tulsipur"];
            break;
        case "pyuthan":
            optionArray = ["ayirabati", "gaumukhi", "jhimruk", "mandavi", "mallarani", "pyuthan", "sarumarani", "sworgadwary"];    
            break;
        case "rolpa" :
            optionArray = ["gangadev", "madi", "pariwartan", "rolpa", "runtigadi", "sunil_smriti", "sunchhahari", "thawang"];    
            break;
        case "rukum" :
            optionArray = ["bhume", "putha_uttarganga", "sisne"];    
            break;
        case "banke" :
            optionArray = ["baijanath", "duduwa", "janki", "kohalpur", "nepalgunj", "rapti_sonari", "khajura"];    
            break;
        case "bardiya" : 
            optionArray = ["bansagadhi", "barbardiya", "badhaiyatal", "geruwa", "gulariya", "madhuwan", "rajapur", "thakurbaba"];
            break;

        // karnali pradesh
        case "dailekh" :
            optionArray = ["aathabis", "bhagawatimai", "bhairabi", "chamunda_bindrasaini", "dullu", "dungeshwor", "gurans", "mahabu", "naumule", "narayan", "thantikandh"];    
            break;
        case "dolpa" :
            optionArray = ["chharka_pangsong", "dolpo_buddha", "jagadulla", "kaike", "mudkechula", "shey_phoksundo", "thuli_bheri", "tripurasundari"];    
            break;
        case "humla" :
            optionArray = ["adanchuli", "chankheli", "kharpunath", "namkha", "sarkegad", "simkot", "tanjakot"];    
            break;
        case "jajarkot" :
            optionArray = ["barekot", "bheri", "chhedagad", "junichande", "kuse", "nalagad", "shiwalaya"];    
            break;
        case "jumla" :
            optionArray = ["chandannath", "guthichaur", "hima", "kanakasundari", "patrasi", "sinja", "tatopani", "tila"];    
            break;
        case "kalikot" :
            optionArray = ["khandachakra", "mahawai", "naraharinath", "palata", "pachaljharana", "raskot", "sanni_tribeni", "subha_kalika", "tilagufa"];    
            break;
        case "mugu" :
            optionArray = ["chhayanath_rara", "khatyad", "mugum_karmarong", "soru"];    
            break;
        case "salyan" :
            optionArray = ["bagchaur", "bangad_kupinde", "chhatreshwori", "darma", "kapurkot", "kumakh", "kalimati", "siddha_kumakh", "tribeni"];    
            break;
        case "surkhet" :
            optionArray = ["barahtal", "bheriganga", "birendranagar", "chaukune", "chingad", "gurbhakot", "lekbeshi", "panchpuri", "simta"];    
            break;
        case "rukum" :
            optionArray = ["aathbiskot", "banfikot", "chaurjahari", "musikot", "sani_bheri", "tribeni"];    
            break;

        // sudhur_paschim pradesh 
        case "achham" :
            optionArray = ["bannigadhi_jayagadh", "bannigadhi_jayagadh", "chaurpati", "dhakari", "kamalbazar", "mangalsen", "panchadewal_binayak", "ramaroshan", "sanphebagar", "turmakhad"];    
            break;
        case "bajhang" :
            optionArray = ["bithadchir", "bungal", "chabispathivera", "durgathali", "jayaPrithivi", "kedarseu", "khaptadchhanna", "masta", "saiPaal", "surma", "talkot", "thalara"];    
            break;
        case "bajura" :
            optionArray = ["badimalika", "budhiganga", "budhinanda", "gaumul", "himali", "jagannath", "khaptad_chhededaha", "swami_kartik_khaapar", "tribeni"];    
            break;
        case "baitadi" :
            optionArray = ["dasharathchanda", "dilasaini", "dogadakedar", "melauli", "pancheshwar", "patna", "purchaudi", "sigas", "shivanath", "surnaya"];    
            break;
        case "dadeldhura" :
            optionArray = ["ajaymeru", "alital", "amargadhi", "bhageshwar", "ganayapdhura", "nawadurga", "parashuram"];    
            break;
        case "darchula" :
            optionArray = ["apihimal", "byas", "dunhu", "lekam", "mahakali", "malikaarjun", "marma", "shailyashikhar"];    
            break;
        case "doti" :
            optionArray = ["adharsha", "badikedar", "bogtan_foodsil", "dipayal_silgadi", "jorayal", "k._i._singh", "purbichauki", "sayal", "shikhar"];    
            break;
        case "kailali" :
            optionArray = ["bardagoriya", "bhajani", "chure", "dhangadhi", "gauriganga", "ghodaghodi", "janaki", "kailari", "lamkichuha", "mohanyal", "tikapur"];    
            break;
        case "kanchanpur" :
            optionArray = ["bedkot", "belauri", "beldandi", "bhimdatta", "krishnapur", "mahakali", "punarbas", "shuklaphanta", "laljhadi"];    
            break;
    }

    for(var count in optionArray){
        var vlu = optionArray[count];
        var opt = document.createElement("option");

        var array = vlu.replace("_"," ").split(" "); 
        var display_name = "";
        for(var x in array){
            display_name += array[x].charAt(0).toUpperCase() + array[x].slice(1) + " ";
        }

        opt.value = vlu;
        opt.innerHTML = display_name;
        s2.options.add(opt);
    }
}