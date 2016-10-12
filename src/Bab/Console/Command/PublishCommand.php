<?php

namespace Bab\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Swarrot\Broker\MessageProvider\PeclPackageMessageProvider;
use Swarrot\Broker\MessageProvider\PhpAmqpLibMessageProvider;
use Swarrot\Consumer;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Bab\Swarrot\Processor\DumbProcessor;

class PublishCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('publish')
            ->setDescription('publish some messages')
            ->addArgument('provider', InputArgument::REQUIRED, 'Provider to test [ext|lib]')
            ->addOption('messages', 'm', InputOption::VALUE_OPTIONAL, 'How many messages to get ?', 1000)
        ;
    }

    protected $message = <<<EOT
Lorem ipsum dolor sit amet, vivendum molestiae his ei. Laboramus assueverit ne his, nec oratio platonem definitiones cu. Autem sanctus his in, at velit nostrud denique duo. Mei docendi torquatos conceptam ex.

Ex nibh consequuntur has, discere copiosae ad his, per at unum brute choro. Cu eam diam legere. Eam utamur appetere reformidans in. An eos delenit singulis reformidans. Ei inermis molestie qui. Eu eos munere causae doctus, ius ea iusto rationibus, vero consectetuer qui an.

Malorum menandri ad sed, duo omnis offendit liberavisse cu. Pro ei enim utinam, vix cu vidisse quaerendum, vocibus minimum eos ut. Luptatum forensibus at cum, ut eum dicunt virtute patrioque, vix veritus urbanitas ne. No dolor vulputate vix. Ad tota utinam fuisset per, nec noluisse instructior et, ne est labores admodum.

Sed probatus invenire delicatissimi cu, dicta munere at est. Nisl everti impetus vix ei. Agam munere inciderint cum ne. Ius no moderatius consequuntur, singulis salutandi definitiones sed ei.

Eos noster philosophia cu. Vis in sumo pertinax scribentur, nam et gubergren suscipiantur, mel fugit labore quodsi eu. In labore pericula repudiare vel, te posse vivendo his. Et sed tota altera facilisis, graece timeam his te. Eos ad sensibus percipitur. Eu commodo molestie pri, ex mea verear philosophia. Ullum dolore vocent cu cum, brute aliquam intellegam mel ad.

Ponderum hendrerit usu at, vim illud dolores at. No vivendo honestatis pro, no qui prompta albucius invidunt. In pri platonem conceptam, ex modo iriure rationibus per, eu vide voluptua dignissim quo. Pro ad wisi atqui dissentiet, ad eam quod omnesque definitionem. Feugiat blandit definiebas vel at, eum aliquando accommodare ad. Pertinacia inciderint ad eam.

Ut posse iuvaret dolorum eos, ne sed choro hendrerit. Corpora insolens atomorum ad eam, diam voluptatum qui in. Sint oratio pertinacia vix ad. Ne nullam soluta blandit qui. Has te zril detracto adipiscing, eu mea ludus ignota vulputate, ne pro mandamus ocurreret.

His te error phaedrum voluptaria. Ut invenire maiestatis qui. Pri at case paulo, vel dicant option corpora ex. Mei an alii natum. Ex quo luptatum scribentur repudiandae, ius placerat assentior definitiones id, odio salutatus ut sed. Qui dicat sensibus et.

Vim in delicata splendide, posse noster legimus per id, his ut etiam nusquam nominavi. Ius enim iusto eloquentiam cu, ad vis semper deserunt intellegat, liber tation verear mel at. Qui labore appareat imperdiet eu, vocibus torquatos persequeris pro ad. Vis ad legere ullamcorper.

Homero debitis nusquam at nec. His affert fuisset democritum cu, vel dicant omnium quaestio ex, et mei omittam explicari theophrastus. Verterem perpetua eos ei, ius an natum eruditi, est elit adhuc putant cu. Has no postea utroque, at vis autem minim indoctum.

Quas brute interpretaris sea ea, expetendis disputando vis in, sed prima nonumes eu. Quodsi invenire perpetua vix eu. Cu iusto veniam usu, per qualisque posidonium cu, id sumo sententiae pro. Falli ancillae repudiare et ius, per fabulas labores tacimates id.

At quo iusto sonet, nam case dolore gubergren no, postea pertinax te vel. Ea vim probo putent, eruditi tibique an quo, ex quo inani percipitur. An posse epicuri mei, sed ad minim democritum, mei facer malorum necessitatibus ei. Et vocibus deleniti accusata vis, mel te delectus appetere, eam inani laoreet ne. Et vel rebum rationibus.

Mea et possim delenit, an duo mundi regione nostrum, tollit propriae detracto ex quo. An vidit autem omnium mei, pericula gloriatur dissentiet mei ne, posse definitiones nec no. Adhuc similique adversarium qui no. Fabulas maiestatis ne vix, at decore postea contentiones nam, nec ut meis scaevola. Soluta nostro consetetur ne nam, nusquam oporteat eu mei.

His ut quando persecuti, ea ullum accumsan vel. Omnes corpora appetere eam ea, aeterno platonem incorrupte has ex. Harum denique efficiendi et usu, id pri posse putent. Rationibus scriptorem mediocritatem no ius, sit ut deleniti aliquando. Aliquid appareat qui te. Vel porro affert ei, per ne fabulas splendide.

Mei no adhuc appareat. Amet putent feugait ex est. Duo solum posse nulla in, eum ut suas reformidans. Eu prodesset philosophia duo. Volumus vulputate pri id, et minimum omittam gubergren eam, pro feugiat periculis ut.

Ut nam summo iisque, eam cu oratio argumentum. Ex veri maiorum nam, equidem nonumes singulis cu est. Ne diam stet eos, unum fierent sadipscing cu nec. Vix an quis dicat, pri te tantas aliquando consequuntur. Ceteros copiosae perfecto ne pro, at duis affert eum.

Veri vocent in est, cu vis fuisset vituperata constituam. Est doming invidunt aliquando ut, his cu iriure quaeque docendi. Eros inermis volumus sit id. Prima graece in duo, in debet tractatos sapientem nam.

Eos etiam electram abhorreant at, ei ius putent integre, te sed odio vitae pericula. Sed admodum reprehendunt ad. At duo facete eripuit omittam, summo consul soleat vis ea. Ad dicit vivendum intellegat est, vitae nusquam vix ea, an doctus alterum legendos quo. Nec errem intellegat id. Propriae vivendum ad eum, eum ex partem aeterno regione, sed ea porro moderatius.

Mea in velit erroribus democritum, an quo dicam officiis, an quo labore splendide. Enim libris mea id, illud pertinax eos at, meis autem per ne. Ei latine minimum sed, ex quo nisl gloriatur. Vide feugait copiosae eos ut, an per paulo audiam intellegebat, cibo porro percipit sea ei. Iuvaret facilis appellantur has eu, stet honestatis repudiandae duo eu.

Et liber omnium mentitum eos, minim theophrastus mei in, in usu ullum repudiandae. Solet eleifend concludaturque ne vix, quo cu incorrupte voluptatibus. Quidam semper atomorum te his. Novum tation definitionem pri an, omnes pertinacia deterruisset ne vix. Nam ei fugit doming dissentiunt. Eum ad assum nulla oportere, ad nec prompta insolens partiendo. Ut iisque docendi ocurreret vim, consequat signiferumque no usu.

Brute lobortis eu sea, te copiosae pericula consetetur eos. In nec inani congue, mel dictas audire dissentiet cu. Quo no adipiscing eloquentiam. Usu at assum pertinacia. Mei graeco blandit ut, probatus intellegam vel ut, at falli moderatius scripserit eos.

Ad assum molestie vel. An solum deseruisse referrentur nam, his aliquip bonorum temporibus cu, ei ius dicit maiestatis. Sea nostrud maiorum no, ne mel causae inermis maluisset, summo iriure deserunt no mel. Ad vel sonet timeam. An vis enim esse adversarium, duis dolorem ad his.

In pri aliquam urbanitas, cu quodsi prompta electram vel. Ut nam reque qualisque quaerendum, ut illum rationibus est. Doctus adversarium instructior id vel, dicant virtute te mei, pro nonumes posidonium et. Adhuc repudiare intellegebat cu eos, his modus diceret suscipiantur cu, docendi constituto ut has. Vel impetus concludaturque ea, ad sit iuvaret periculis appellantur, pro congue iuvaret ex. Qui choro lobortis te, est illum solet nominavi te.

Possim hendrerit ut qui, ut falli expetenda mei. In dicunt fuisset mentitum mel, eu sumo expetenda adversarium sed. Ut nec tantas phaedrum erroribus, eos eu inermis urbanitas. Vim ad semper dictas expetendis, eos mucius minimum aliquando at, cum an quot audiam legimus.

Malis definiebas cum at. Id vim eros invenire. Labores molestiae at has, eum at facer scripta ponderum. Pro ei feugait aliquando, vix et deseruisse appellantur, id feugiat perfecto ius. Nec alii commune ancillae in, ne quando melius pertinacia pro. Soluta probatus neglegentur ad mea.

Qui ex etiam exerci insolens, omnis euismod urbanitas et nec, utamur aeterno postulant ea has. Id denique lobortis pro, vix at iisque suscipit invidunt. Aperiam postulant deterruisset quo te. At mei invenire deterruisset.

Illum omnes eligendi vim ad, an ius natum sonet officiis, vide tibique ius ea. Quando recusabo iudicabit cu usu, commune appellantur qui in, ne vivendo eloquentiam referrentur qui. Ius et quot omnium. His iisque copiosae elaboraret ea.

Has verear offendit ne, laudem omnesque vituperata usu et. In hinc falli ius. Aperiri ancillae facilisi eu vix, et discere pertinacia theophrastus vel. Vim dicant nonumes verterem ut, eu pericula percipitur sea. Te assentior dissentiunt mei, has ne summo discere. Ut graece iuvaret his, partem voluptua inciderint vel ut.

Vivendo eloquentiam adversarium ea duo, eu mei choro efficiantur, ad ancillae delectus has. Ut pri error nostrum, ea sensibus disputando mei, postea invidunt has ne. Ius quas delicata honestatis cu. Novum graeco abhorreant per ad.

Eu est dicat facilis, ei vis case tation mediocritatem, an adhuc quodsi mei. Agam purto consequat eam id, ut elitr omnium vim. Cu justo laudem usu, sit modo omnesque ei, prompta accusata mea no. Ei sed habeo accusamus sententiae.

Qui ad solet perpetua. No adipisci pericula duo, te qui postea fabellas perpetua, ad nisl libris invidunt mea. An nibh blandit has, et vix graeci everti aliquam. Mea altera conclusionemque eu, eum ad possit iracundia accommodare.

Sumo quidam legendos ut his, at nec magna mazim. Ea his dicam petentium, in apeirian constituam vim. Eos veri dissentiunt ex, electram conceptam efficiendi te his. Vix tempor insolens ei, duo at modus maiestatis interesset, an quodsi persius vel. Ne pri mnesarchum definitionem, his harum habemus accommodare at. Pro vero omnesque ei, incorrupte honestatis in sit, mel graeci quaeque ex.

Cu vix amet sumo detracto. Vidisse corrumpit consectetuer eos id, at quo probo explicari. Mel no ullum disputationi, an natum simul his. Quo ad sumo rationibus, eos ex utinam vocibus singulis. Ne mel eros liberavisse. Blandit ponderum postulant vis no, rationibus instructior et vel.

At qui mundi equidem, quo et idque accumsan intellegam, ne est delectus nominati interesset. Te dico deseruisse est, his ne antiopam perpetua. Te impedit signiferumque est. Ut eius aperiri eos.

Exerci dolorum quaerendum eum an, vis quando nullam oporteat cu. Ad sit novum fuisset. Ea mel elit aliquam, ei discere diceret impedit sit, vel at alii dico. Eu solum efficiantur mei, mucius luptatum ex pro.

Has ut essent impetus perfecto, malis graecis at vel. Delenit iracundia pro ea, ne facilis lobortis vituperatoribus his, mea te aeque mundi equidem. Usu ex amet sint vivendum, an dicat etiam mandamus eam. Ad case velit duo, qui epicuri temporibus cotidieque te. Ad qui lucilius definitionem, qui an autem quidam graecis, per quem labore pertinacia te. Ei per etiam apeirian consetetur. Ei meis dicant vis.

Eos at choro ancillae complectitur, pri at cetero aeterno erroribus. Debitis imperdiet pro te, adhuc utinam laboramus ex vix. Cu nostro aliquip vix, sale zril delectus qui te. Ut aliquid similique nam, affert discere eum in.

Pri legere salutandi evertitur ut, ad cum noster corrumpit interpretaris. Case ubique et mel. Mei ad habeo inimicus, et sed eius maiestatis expetendis. Putant blandit sit ex, est meis sapientem ad. Debet ancillae ius ad, eam at dolorum tractatos.

Ex pri alii euripidis, ferri repudiare vel ne. Docendi detracto per ad, possim eruditi et per. Mei at graece detraxit, invidunt reprehendunt te vis. Qui iriure facilis delicata no. Vel iusto iisque volutpat at, velit melius disputationi ne est.

At mei accusata liberavisse, ullum splendide cum ea. Putent nostrum quo eu. Ei mei altera dicunt appetere. Ea ius delenit aliquando repudiandae. Id sit vidit zril recteque, ea his quod elitr labores. Ex tation definitionem eos, epicuri scaevola expetenda eam at. Duo cu causae disputando, eos cu velit denique comprehensam, labore maiestatis voluptatibus vis ex.

Quo at quas homero forensibus. Hinc tota altera vel no, ut mei choro regione efficiantur. Sit et viris populo aperiri, ex eum virtute vituperata, in nam augue impetus. Mea at tation oblique singulis, sea ei facilisi evertitur.

Vim ut meis libris incorrupte. No mazim disputationi definitiones usu, at eros dicat facilisi eum, tempor malorum fabulas mea ne. No autem delicatissimi usu, dolorum reprehendunt usu in, eu mei justo forensibus. Facete explicari sit at, ad nisl animal eruditi eum, ut per elit praesent consequat. Eu mea utamur iisque legendos. Pri at oblique omittantur, modo essent scriptorem at eam. Legimus meliore ea qui, civibus contentiones vel an.

Sit cu putant similique, vim te quis autem causae. Tation neglegentur eos ei, ubique possit fabulas duo ad, usu no esse sententiae. Ut vim tale erant nusquam, ea ius harum virtute conceptam. Ad malis error quo, novum iudico dissentiet an per. Et nec nobis qualisque, pri noluisse insolens ad. Ex quo perfecto disputando.

Sumo aperiri percipit no est, nam ne nostrum lucilius consequat. Eam id case veritus. Nibh graece similique pri in, tota ullum pro ut. Ei inimicus recteque nam, libris docendi vim eu. Veniam incorrupte ius in, te quis splendide qui.

Vel hinc mutat pericula ei, sale oratio vis cu. Mei ea deleniti apeirian, te mea aeque facilis assueverit, omnis partiendo omittantur no sed. Lorem impedit at nec. An oblique iracundia vis, nec dicit soluta id. Te doctus alienum usu. At ornatus delenit sed, et homero docendi suavitate has.

Cu quo indoctum splendide. Suas luptatum repudiare in mea, cum vero officiis ea, no euismod deserunt mea. Harum fabellas definitiones pro id, ne mea sonet urbanitas. Ad consulatu instructior ius.

Sit errem equidem volutpat ei, ex vim meis ipsum, timeam iisque quo ex. Impetus definitionem in quo, ei case tollit eam, pro id cetero reprimique. Has suscipit recteque at, debitis habemus volutpat cum te, ex vel quem numquam. Eu usu meliore placerat evertitur, eum ei esse albucius omittantur. Has liber forensibus deseruisse at, ut viris dolores pri.

Eu duo omnis oportere urbanitas, copiosae tacimates eos ea. Et ipsum definiebas has, fugit animal vim te, paulo appareat per in. Mundi viderer an vim. Zril reformidans ut vel.

An eruditi constituam duo. Id causae alienum consectetuer quo. At est hinc probatus, ex brute habemus posidonium cum. Quas vidit usu ea. His ei hinc affert fabellas, probatus disputando qui et.

Vix explicari theophrastus in. Te quodsi fuisset commune sea, suavitate explicari prodesset ius ex, pro an accumsan senserit. Vis cu mucius nemore intellegam. Id exerci ignota sit, cu eum commodo graecis.

Cu eum ubique admodum aliquando, ut fuisset phaedrum torquatos usu. Duo unum simul lobortis cu, feugiat tractatos consequuntur eu vis. Est at diceret saperet principes. Cum ad apeirian hendrerit.

Omnesque temporibus dissentiunt nec id, dolor discere deleniti mei te, nusquam temporibus in sed. Pri atqui corpora ea. At exerci dolore quaestio mei, has ei dictas cetero veritus, sit nulla fuisset erroribus ei. Luptatum phaedrum interpretaris vix ad. Id mei modo prodesset pertinacia. Ferri repudiare moderatius cu qui, ferri expetendis posidonium ea vis, eam invidunt evertitur cu. Eos ei errem nonumes, est an movet appellantur.

Ut inermis dolores vis. Aeque salutandi posidonium duo te, eu putent dignissim interesset sit. Eos brute prompta in, iudico laudem ocurreret mea ne, amet putant maiestatis no vis. Aliquid cotidieque ex nam, pri vide veri melius ex. Odio agam voluptatibus pri no, eius dissentiunt in mei.

Impedit philosophia duo ex. Eu has ridens pertinacia deseruisse, has ex tale complectitur. Vis ex falli erroribus, sed ut utamur phaedrum maiestatis. Fuisset constituto cum in. Ei tempor singulis dissentias vim, labore instructior ea pri. Vide mundi ne sed, utinam persecuti liberavisse eam an.

Mei cu malorum intellegat percipitur, vocent explicari vix et. Ei mei alii concludaturque. In rebum atomorum suavitate duo, amet percipitur temporibus sea ea. Debet noluisse constituto id sed.

Phaedrum dignissim ei vix, his ex labore laboramus disputando. Facer delectus vix ad, perfecto inimicus gubergren ex cum. Vel ne hinc minim, et nominavi theophrastus sit, minimum repudiare est ea. Eu tale vituperata pro, alii eripuit ocurreret eu sed. In duo fabellas democritum. Autem aeque elitr nec no, pri ludus intellegat consequuntur id, no clita imperdiet vix. Nec no aliquip quaestio expetendis.

Ea sea modus atqui, qui et iisque maiorum nostrum. Eum aliquip vituperatoribus ea. Mei ut homero aliquip intellegebat, congue forensibus cum ad. Vidit graeco ei has. Dicit commodo sanctus eam eu, alii dico oporteat ut quo.

Patrioque evertitur ne sed, facer affert vim ei. Ei cum noster senserit contentiones, ne eum affert debitis. Ius alienum sententiae ei. Semper persius lucilius has id.

Eum in vide latine fabulas. Ancillae sensibus explicari duo no, at dictas detracto liberavisse his, ne laboramus persecuti cum. Has falli vidisse ne, suas eius interesset pri at. Eam quodsi intellegat intellegam at, no nec feugait vivendum. Vis vide eloquentiam theophrastus et, sit percipit facilisi similique te. Te pri stet erroribus.

Has ne iuvaret phaedrum. Nobis debitis mei ut, impedit tibique forensibus ea has. Eum at facilisis sententiae. Dolorum detraxit repudiare ea sed.

Eum eu falli ponderum comprehensam, ad brute persius perfecto cum. Oblique eripuit laoreet est ut, ne elit congue mel, nam cibo tantas mollis no. Vix agam dicta ea, pri paulo officiis conceptam an. Ad vis lobortis delicata mediocritatem, duo nulla appellantur consequuntur ne, aliquip consetetur quaerendum duo cu. Cu tantas putant conceptam mei, populo meliore vis ut. Labitur nominati efficiantur ex cum.

Vix eu omnes definitiones, habeo possit necessitatibus te his, augue erroribus quaerendum mei ad. Suas nominati an duo. Eu mutat decore regione nec, patrioque assueverit ei quo. Mei ei dolorem blandit. Mea at autem nulla scriptorem. At eos tale appetere.

Ei ius inimicus qualisque. Bonorum liberavisse vim et, qui at brute deleniti ponderum. In partem mucius maiorum vix, brute delicatissimi ex qui. Reque latine conclusionemque no per. Ne decore imperdiet constituto sit. Ius mundi suscipit ad.

Partem theophrastus cu pri, sea affert labitur et. Graece voluptua sit id, ex autem errem nihil sed. Voluptua expetenda ut pro, vis id blandit lucilius. Duo inani eripuit democritum ut, essent minimum at pro, mundi persius molestie ad duo.

Melius suscipiantur has an, nostrum temporibus eu vix. His ad bonorum constituto, ei sit epicuri ponderum, animal consequat in quo. No nec quaerendum dissentiunt, eum habeo nemore gubergren ea. Mei elit munere contentiones eu, facer congue ne nam, vidisse moderatius his ad. In vix feugait corrumpit, nam an ridens graeco reprehendunt.

Populo albucius id nam, sea vivendum constituto at. Magna ullamcorper est cu. Et mel reque facer, causae efficiantur cum an. Has et alii scaevola corrumpit. Per tale tempor impedit ne, nam recteque partiendo ei. Nostrum fastidii id cum.

Nam erroribus hendrerit dissentiunt ei. Pri tacimates hendrerit reprehendunt eu. Cum ne aeterno nonumes postulant, no simul periculis pertinacia pri. No choro quaestio referrentur mea. Vim admodum intellegat no, id audiam ceteros albucius quo, summo invenire periculis ut sea.

Ornatus quaestio evertitur ei sed, ei doming partiendo sed. Usu summo delenit an, ad nec aliquam omnesque eligendi, dicam aeterno vel et. Id ubique efficiantur sit. Vel vivendum consetetur ei, copiosae percipitur sit cu. Quot fierent maiestatis te has. Mei invidunt assueverit efficiantur et. Ea pri possit iriure rationibus.

An deleniti erroribus omittantur pri, doctus adolescens id eos. Nec odio quando torquatos te. Libris placerat ius at. Quis conceptam ei per, has hinc vero movet id.

Vis ea unum nemore apeirian, an dicat electram adolescens vis. Vel in corpora albucius nominavi, quo cu dicit putent quidam. Facilisis voluptaria mel ne, ea quis elitr repudiandae mei. Ei vis vidit probatus, eirmod labitur legimus ne per, dicat laoreet has in. Zril aliquip quaerendum his ex, an his velit quodsi interpretaris.

Duo viderer tractatos eu, eum clita sapientem facilisis ei. Eu duo vero dolore nullam, et diam delectus accommodare usu. Eam autem iuvaret eu, an tale ferri democritum nec. Usu atqui voluptatibus ne, his corrumpit scribentur at. Vim nibh atqui voluptatum ea, eu sonet vocent qui. Ne his alienum mentitum, labitur volutpat ex est, eum nostrud corrumpit in.

Commodo fierent partiendo ad sea, cum impetus senserit necessitatibus ea, quo te mutat movet vocent. Oblique corpora te cum, propriae nominavi deterruisset nam id. Eu euismod ancillae similique mei. No scripta atomorum vituperata vis, ut probo euismod definitiones sed, erat liber atomorum eos cu. Luptatum sapientem id ius. Honestatis liberavisse et pri, eu pro liber reprimique, vero soleat accusamus per eu.

Has stet labore percipitur ea, nec et dicam referrentur, sit id augue dictas. Cu verear audire temporibus per, sit nobis fierent cotidieque in. Harum omnes homero quo ex, ignota principes est at, quis comprehensam pri ad. Offendit mandamus pri te, ea vocent laboramus eos. Nostro forensibus constituto ad eam, ornatus interpretaris mea et.

Te vis dictas copiosae omittantur, vidit invenire instructior est ne. Eu sit viris efficiantur. His id eius iudicabit, et nec mollis reprehendunt. Tale saperet contentiones ei pro, ea possim impetus concludaturque cum. Ad imperdiet scripserit sea, dicit molestie sententiae ne sea, mel option temporibus at.

Everti mollis in vix. Erat justo consectetuer ius ex. Affert lucilius salutandi vix ut, sed ea nisl nostrud posidonium, eu cum alia insolens. Est te dicant aliquando adipiscing, ne has atqui copiosae reprimique. Te timeam perpetua mea, at graeci concludaturque per.

Integre dolorem signiferumque vim et, sea idque veritus persecuti te. Alii idque ei eos. Mea cu semper vivendo abhorreant. Ei duo percipit similique. No partiendo molestiae vulputate his, vix in voluptaria scribentur, ne eam hinc ancillae.

Et has percipit dignissim argumentum, prompta tibique mel ne, ne audire consequat duo. Fuisset blandit sit cu, eos aeterno nusquam et. Eu nam legere oportere. Eu aeterno blandit assueverit his, sea te tale rebum percipit. Sea posse nullam at, his in modus dignissim.

Omnis laoreet ex vis. Vim quaeque iudicabit mediocritatem an. At qui minim invidunt gloriatur, choro laoreet voluptua vix et. Qui modus posidonium temporibus ea, cu pri reque lobortis. Zril everti timeam qui te. Vis populo mentitum no, eu mea aperiam suscipit. Viderer ancillae noluisse sea ut.

His wisi perfecto ea, ut dicat accumsan antiopam eum. Mel dolore expetendis ne, at est idque dissentiet, vix falli eruditi et. Vel an alia volumus repudiandae. Eu forensibus inciderint referrentur sed.

Diam ceteros mea te, vel rationibus definitionem no, mea id veri officiis suscipiantur. No nec assum praesent eloquentiam. Sea ad assum dissentias, eros lorem vocibus at vim, habeo scaevola qualisque cum eu. Vix ad zril perpetua repudiare, tibique vulputate eu mel, aeque clita melius an nam. Id etiam vivendum sed, principes interpretaris pro et. Cu porro elitr inermis sea.

Fabellas mediocrem ea qui, ius case dictas an. Mei id dicam alienum recusabo, noster fastidii mnesarchum at vis, quis argumentum ullamcorper cu his. Consetetur instructior ea sed. Est ex quodsi aliquid. Id imperdiet evertitur pertinacia mea, esse perpetua an mel.

Et mei affert eirmod postulant, semper omnesque adolescens mel id. Zril populo ancillae ut his, solum persecuti vel an. At quodsi intellegebat eum, feugiat luptatum repudiare cum ut. Nam ad quando libris quidam, vel in indoctum consectetuer. Ea eum minimum detracto sensibus, sit partem vocent id.

Est ut vivendo tibique menandri, unum epicurei splendide qui at. Discere inimicus expetendis vel an. Consul principes cum ne, ei recteque suavitate imperdiet has. Timeam utamur eu ius, error facilis et sea. Vix errem equidem appetere no. Vis dicam possim oportere at, mandamus expetenda voluptaria ad qui, ei detracto elaboraret disputando eum. Cotidieque delicatissimi te quo.

Omnium persius intellegam duo ea. Appetere lucilius te duo, his ei solum primis labore, an sea habeo consulatu. Vel minim adolescens intellegebat id. Ea vis prompta intellegat, nam expetenda hendrerit et. Ius vivendo salutandi iudicabit et, sit an denique imperdiet persecuti.

Mea ne sonet mediocritatem, his ei ponderum elaboraret, nec cu purto simul adipisci. Lucilius eleifend sapientem nam ex, in alienum tractatos definitionem qui. Pri eu offendit adolescens delicatissimi. Quem dico mentitum pro cu, ex magna solet quo. Omnes vivendo mea at, quem voluptua vix id, mea ad duis omittam.

Aliquam temporibus dissentiet at mel. Wisi dicta ei duo. Epicuri efficiendi id eos. Nam cu aeterno detraxit splendide, eros reprimique ius et. Choro assentior duo ne.

His velit omittam ad, in platonem referrentur nam. Vim id stet euismod signiferumque, ne eum aliquip dolorum. At eos accumsan legendos inciderint, etiam invidunt oporteat his et. No veri velit his, no labitur elaboraret eos, delenit iracundia at vim. Sit suas eripuit eu, ut congue reformidans quo. Paulo latine insolens usu eu, cum in dicta tamquam.

Delenit accusamus nam an, at erant causae debitis mel. Eum an ceteros facilisi ocurreret, cu est tantas aperiri malorum, in iudicabit vituperata elaboraret mel. Saepe scripta comprehensam qui et. Pro erant mollis ancillae eu, ei illud eripuit numquam has, at tamquam interpretaris concludaturque ius. Admodum conceptam sit ei, ius et duis ignota. An nam fierent disputationi, fuisset oportere praesent vim ex. Cum ex etiam dicta assentior.

Ex mel debitis molestiae, nulla vivendo his at. Quo bonorum legimus graecis in, an quo nullam semper essent. Perfecto scribentur interpretaris te duo. Et eos soleat reprimique, an erat adhuc sed, ius inciderint instructior id.

Duo odio error commune ne. Sit et quaeque fastidii convenire. Usu assum diceret facilisis at, dolor insolens ullamcorper te sed. Id mei graece delicata postulant, vis consulatu referrentur definitionem te, ponderum apeirian efficiantur ius te. Pri te phaedrum erroribus, cetero referrentur id his, ea doctus alterum sit.

Cum quas aperiam moderatius no, ei sit tempor fastidii. Dico hinc temporibus te cum, eum id vivendo appetere scriptorem. Ea sale nulla tantas est, intellegam dissentiet id cum, pro falli elaboraret ea. Officiis petentium repudiare pri an, iudico consulatu quo id.

Ne sit mundi aeterno, ad mea solum malorum quaestio. Laudem nominati mediocrem sed eu, no dolor perpetua persecuti vim, omnes mucius ornatus duo ne. Eum ei omnis theophrastus, eu iriure graecis sea. Ius alterum constituam an.

Sit at debitis imperdiet, detracto recusabo ad vim. Nominavi vituperatoribus an his, quaeque sanctus voluptua eu est, duo ex prima verterem. Aperiam delenit consetetur cu nec, ne prima impetus deserunt sed. Nec simul moderatius philosophia te, an sea nulla menandri, id melius euripidis pro. Eam causae nostrud an. Id habeo inciderint vis, et sea case munere docendi.

Modus maiorum omnesque vel te, usu putant malorum euripidis ea. At consul alterum cotidieque pri, te nec summo utamur aliquam. Vix ex idque populo democritum, per illum lorem adolescens cu, te facer periculis gubergren est. Sed ne tempor dissentias, an eos nulla patrioque rationibus. Ex enim nominavi praesent quo, ridens propriae sit cu.

Te intellegam scribentur mei, fabellas intellegebat cum ne, id mel utroque accommodare. Quem modus intellegam sed id, sit oratio laudem ne. Elit aliquid eam in. Nec zril pertinacia ut, has in stet lobortis intellegebat, mutat dicunt te ius. Mel melius veritus an. Pri at libris postea aliquando, his ne tamquam adolescens.

Odio comprehensam usu ad, an vel aliquid feugait partiendo, pro melius accusata corrumpit ne. Munere nusquam moderatius ad vix, eam convenire voluptatum an. Eu nullam omittam deseruisse vim, pro eu dicat malorum voluptatibus, erat prompta expetenda est id. At mundi sonet iuvaret nam.

No solet graecis intellegam usu, cum in legere definiebas. Nec in vero abhorreant conclusionemque, quo porro nonumy molestiae ex, soleat quaeque accumsan mei an. At quando luptatum sit, melius disputationi vis ex. Convenire forensibus te pro, elit quidam te qui. Paulo eirmod sea no, iusto graeci eos an, no paulo vocent consequat mea.

Ei est elitr recusabo, quot quaeque eleifend ex has. Te minimum cotidieque pri. Et ludus tempor aperiri has, primis splendide assentior cu nec. Tale verear at nec, ne vis aliquam mentitum. Dolore theophrastus ei sed, ponderum imperdiet constituto ne vim, ne equidem tacimates senserit quo.

Petentium dignissim urbanitas et usu. Ius dolore graece cu, et vis ceteros dolores suscipit, eruditi sanctus fabellas eum id. At sed enim tation forensibus. Ei consul persecuti his, laudem reprimique pri cu. Usu ferri erant sonet at, pro eligendi petentium consulatu eu. Ad doming latine vis. Solum latine cum eu, magna adolescens cu eos.

Atqui assum denique cu nam. Case placerat ei pri. Modo aliquando definiebas ex nam, sed no aperiam iuvaret tractatos. Vix suas mutat aperiri eu. Mea cibo minim in, ius at pertinacia adversarium delicatissimi. Nonumes repudiandae vim ne, id has hendrerit consetetur.

Mei ne lorem oratio persecuti. In quo oratio delicatissimi, eu his facer tincidunt repudiandae, duo cu aliquam fuisset appellantur. Cu nibh legere mandamus vis, ea vero reque eam. Quo et postea doctus euripidis.

Admodum adipisci splendide.Lorem ipsum dolor sit amet, vivendum molestiae his ei. Laboramus assueverit ne his, nec oratio platonem definitiones cu. Autem sanctus his in, at velit nostrud denique duo. Mei docendi torquatos conceptam ex.

Ex nibh consequuntur has, discere copiosae ad his, per at unum brute choro. Cu eam diam legere. Eam utamur appetere reformidans in. An eos delenit singulis reformidans. Ei inermis molestie qui. Eu eos munere causae doctus, ius ea iusto rationibus, vero consectetuer qui an.

Malorum menandri ad sed, duo omnis offendit liberavisse cu. Pro ei enim utinam, vix cu vidisse quaerendum, vocibus minimum eos ut. Luptatum forensibus at cum, ut eum dicunt virtute patrioque, vix veritus urbanitas ne. No dolor vulputate vix. Ad tota utinam fuisset per, nec noluisse instructior et, ne est labores admodum.

Sed probatus invenire delicatissimi cu, dicta munere at est. Nisl everti impetus vix ei. Agam munere inciderint cum ne. Ius no moderatius consequuntur, singulis salutandi definitiones sed ei.

Eos noster philosophia cu. Vis in sumo pertinax scribentur, nam et gubergren suscipiantur, mel fugit labore quodsi eu. In labore pericula repudiare vel, te posse vivendo his. Et sed tota altera facilisis, graece timeam his te. Eos ad sensibus percipitur. Eu commodo molestie pri, ex mea verear philosophia. Ullum dolore vocent cu cum, brute aliquam intellegam mel ad.

Ponderum hendrerit usu at, vim illud dolores at. No vivendo honestatis pro, no qui prompta albucius invidunt. In pri platonem conceptam, ex modo iriure rationibus per, eu vide voluptua dignissim quo. Pro ad wisi atqui dissentiet, ad eam quod omnesque definitionem. Feugiat blandit definiebas vel at, eum aliquando accommodare ad. Pertinacia inciderint ad eam.

Ut posse iuvaret dolorum eos, ne sed choro hendrerit. Corpora insolens atomorum ad eam, diam voluptatum qui in. Sint oratio pertinacia vix ad. Ne nullam soluta blandit qui. Has te zril detracto adipiscing, eu mea ludus ignota vulputate, ne pro mandamus ocurreret.

His te error phaedrum voluptaria. Ut invenire maiestatis qui. Pri at case paulo, vel dicant option corpora ex. Mei an alii natum. Ex quo luptatum scribentur repudiandae, ius placerat assentior definitiones id, odio salutatus ut sed. Qui dicat sensibus et.

Vim in delicata splendide, posse noster legimus per id, his ut etiam nusquam nominavi. Ius enim iusto eloquentiam cu, ad vis semper deserunt intellegat, liber tation verear mel at. Qui labore appareat imperdiet eu, vocibus torquatos persequeris pro ad. Vis ad legere ullamcorper.

Homero debitis nusquam at nec. His affert fuisset democritum cu, vel dicant omnium quaestio ex, et mei omittam explicari theophrastus. Verterem perpetua eos ei, ius an natum eruditi, est elit adhuc putant cu. Has no postea utroque, at vis autem minim indoctum.

Quas brute interpretaris sea ea, expetendis disputando vis in, sed prima nonumes eu. Quodsi invenire perpetua vix eu. Cu iusto veniam usu, per qualisque posidonium cu, id sumo sententiae pro. Falli ancillae repudiare et ius, per fabulas labores tacimates id.

At quo iusto sonet, nam case dolore gubergren no, postea pertinax te vel. Ea vim probo putent, eruditi tibique an quo, ex quo inani percipitur. An posse epicuri mei, sed ad minim democritum, mei facer malorum necessitatibus ei. Et vocibus deleniti accusata vis, mel te delectus appetere, eam inani laoreet ne. Et vel rebum rationibus.

Mea et possim delenit, an duo mundi regione nostrum, tollit propriae detracto ex quo. An vidit autem omnium mei, pericula gloriatur dissentiet mei ne, posse definitiones nec no. Adhuc similique adversarium qui no. Fabulas maiestatis ne vix, at decore postea contentiones nam, nec ut meis scaevola. Soluta nostro consetetur ne nam, nusquam oporteat eu mei.

His ut quando persecuti, ea ullum accumsan vel. Omnes corpora appetere eam ea, aeterno platonem incorrupte has ex. Harum denique efficiendi et usu, id pri posse putent. Rationibus scriptorem mediocritatem no ius, sit ut deleniti aliquando. Aliquid appareat qui te. Vel porro affert ei, per ne fabulas splendide.

Mei no adhuc appareat. Amet putent feugait ex est. Duo solum posse nulla in, eum ut suas reformidans. Eu prodesset philosophia duo. Volumus vulputate pri id, et minimum omittam gubergren eam, pro feugiat periculis ut.

Ut nam summo iisque, eam cu oratio argumentum. Ex veri maiorum nam, equidem nonumes singulis cu est. Ne diam stet eos, unum fierent sadipscing cu nec. Vix an quis dicat, pri te tantas aliquando consequuntur. Ceteros copiosae perfecto ne pro, at duis affert eum.

Veri vocent in est, cu vis fuisset vituperata constituam. Est doming invidunt aliquando ut, his cu iriure quaeque docendi. Eros inermis volumus sit id. Prima graece in duo, in debet tractatos sapientem nam.

Eos etiam electram abhorreant at, ei ius putent integre, te sed odio vitae pericula. Sed admodum reprehendunt ad. At duo facete eripuit omittam, summo consul soleat vis ea. Ad dicit vivendum intellegat est, vitae nusquam vix ea, an doctus alterum legendos quo. Nec errem intellegat id. Propriae vivendum ad eum, eum ex partem aeterno regione, sed ea porro moderatius.

Mea in velit erroribus democritum, an quo dicam officiis, an quo labore splendide. Enim libris mea id, illud pertinax eos at, meis autem per ne. Ei latine minimum sed, ex quo nisl gloriatur. Vide feugait copiosae eos ut, an per paulo audiam intellegebat, cibo porro percipit sea ei. Iuvaret facilis appellantur has eu, stet honestatis repudiandae duo eu.

Et liber omnium mentitum eos, minim theophrastus mei in, in usu ullum repudiandae. Solet eleifend concludaturque ne vix, quo cu incorrupte voluptatibus. Quidam semper atomorum te his. Novum tation definitionem pri an, omnes pertinacia deterruisset ne vix. Nam ei fugit doming dissentiunt. Eum ad assum nulla oportere, ad nec prompta insolens partiendo. Ut iisque docendi ocurreret vim, consequat signiferumque no usu.

Brute lobortis eu sea, te copiosae pericula consetetur eos. In nec inani congue, mel dictas audire dissentiet cu. Quo no adipiscing eloquentiam. Usu at assum pertinacia. Mei graeco blandit ut, probatus intellegam vel ut, at falli moderatius scripserit eos.

Ad assum molestie vel. An solum deseruisse referrentur nam, his aliquip bonorum temporibus cu, ei ius dicit maiestatis. Sea nostrud maiorum no, ne mel causae inermis maluisset, summo iriure deserunt no mel. Ad vel sonet timeam. An vis enim esse adversarium, duis dolorem ad his.

In pri aliquam urbanitas, cu quodsi prompta electram vel. Ut nam reque qualisque quaerendum, ut illum rationibus est. Doctus adversarium instructior id vel, dicant virtute te mei, pro nonumes posidonium et. Adhuc repudiare intellegebat cu eos, his modus diceret suscipiantur cu, docendi constituto ut has. Vel impetus concludaturque ea, ad sit iuvaret periculis appellantur, pro congue iuvaret ex. Qui choro lobortis te, est illum solet nominavi te.

Possim hendrerit ut qui, ut falli expetenda mei. In dicunt fuisset mentitum mel, eu sumo expetenda adversarium sed. Ut nec tantas phaedrum erroribus, eos eu inermis urbanitas. Vim ad semper dictas expetendis, eos mucius minimum aliquando at, cum an quot audiam legimus.

Malis definiebas cum at. Id vim eros invenire. Labores molestiae at has, eum at facer scripta ponderum. Pro ei feugait aliquando, vix et deseruisse appellantur, id feugiat perfecto ius. Nec alii commune ancillae in, ne quando melius pertinacia pro. Soluta probatus neglegentur ad mea.

Qui ex etiam exerci insolens, omnis euismod urbanitas et nec, utamur aeterno postulant ea has. Id denique lobortis pro, vix at iisque suscipit invidunt. Aperiam postulant deterruisset quo te. At mei invenire deterruisset.

Illum omnes eligendi vim ad, an ius natum sonet officiis, vide tibique ius ea. Quando recusabo iudicabit cu usu, commune appellantur qui in, ne vivendo eloquentiam referrentur qui. Ius et quot omnium. His iisque copiosae elaboraret ea.

Has verear offendit ne, laudem omnesque vituperata usu et. In hinc falli ius. Aperiri ancillae facilisi eu vix, et discere pertinacia theophrastus vel. Vim dicant nonumes verterem ut, eu pericula percipitur sea. Te assentior dissentiunt mei, has ne summo discere. Ut graece iuvaret his, partem voluptua inciderint vel ut.

Vivendo eloquentiam adversarium ea duo, eu mei choro efficiantur, ad ancillae delectus has. Ut pri error nostrum, ea sensibus disputando mei, postea invidunt has ne. Ius quas delicata honestatis cu. Novum graeco abhorreant per ad.

Eu est dicat facilis, ei vis case tation mediocritatem, an adhuc quodsi mei. Agam purto consequat eam id, ut elitr omnium vim. Cu justo laudem usu, sit modo omnesque ei, prompta accusata mea no. Ei sed habeo accusamus sententiae.

Qui ad solet perpetua. No adipisci pericula duo, te qui postea fabellas perpetua, ad nisl libris invidunt mea. An nibh blandit has, et vix graeci everti aliquam. Mea altera conclusionemque eu, eum ad possit iracundia accommodare.

Sumo quidam legendos ut his, at nec magna mazim. Ea his dicam petentium, in apeirian constituam vim. Eos veri dissentiunt ex, electram conceptam efficiendi te his. Vix tempor insolens ei, duo at modus maiestatis interesset, an quodsi persius vel. Ne pri mnesarchum definitionem, his harum habemus accommodare at. Pro vero omnesque ei, incorrupte honestatis in sit, mel graeci quaeque ex.

Cu vix amet sumo detracto. Vidisse corrumpit consectetuer eos id, at quo probo explicari. Mel no ullum disputationi, an natum simul his. Quo ad sumo rationibus, eos ex utinam vocibus singulis. Ne mel eros liberavisse. Blandit ponderum postulant vis no, rationibus instructior et vel.

At qui mundi equidem, quo et idque accumsan intellegam, ne est delectus nominati interesset. Te dico deseruisse est, his ne antiopam perpetua. Te impedit signiferumque est. Ut eius aperiri eos.

Exerci dolorum quaerendum eum an, vis quando nullam oporteat cu. Ad sit novum fuisset. Ea mel elit aliquam, ei discere diceret impedit sit, vel at alii dico. Eu solum efficiantur mei, mucius luptatum ex pro.

Has ut essent impetus perfecto, malis graecis at vel. Delenit iracundia pro ea, ne facilis lobortis vituperatoribus his, mea te aeque mundi equidem. Usu ex amet sint vivendum, an dicat etiam mandamus eam. Ad case velit duo, qui epicuri temporibus cotidieque te. Ad qui lucilius definitionem, qui an autem quidam graecis, per quem labore pertinacia te. Ei per etiam apeirian consetetur. Ei meis dicant vis.

Eos at choro ancillae complectitur, pri at cetero aeterno erroribus. Debitis imperdiet pro te, adhuc utinam laboramus ex vix. Cu nostro aliquip vix, sale zril delectus qui te. Ut aliquid similique nam, affert discere eum in.

Pri legere salutandi everti
EOT;
    /**
     * {@inheritDoc}
     */
    protected function doExecute(InputInterface $input, OutputInterface $output)
    {
        $provider = $input->getArgument('provider');
        $nbMessages = $input->getOption('messages');

        switch ($provider) {
        case 'ext':
            $this->publishWithExt($nbMessages);
            break;
        case 'lib':
            $this->publishWithLib($nbMessages);
            break;
        case 'ext-connect':
            $this->publishWithLibConnect($nbMessages);
            break;
        case 'lib-connect':
            $this->publishWithLibConnect($nbMessages);
            break;
        case 'ext-pconnect':
            $this->publishWithExtPConnect($nbMessages);
            break;
        default:
            throw new \Exception("$provider not found");
        }
    }

    /**
     * publishWithExt
     *
     * @param int $nbMessages
     *
     * @return void
     */
    protected function publishWithExtPConnect($nbMessages)
    {
        $connection = new \AMQPConnection([
            'vhost' => 'bench'
        ]);

        for ($i = 0; $i < $nbMessages; $i++) {
            $masterstartTime = microtime(true);
            //            $startTime = microtime(true);
            $connection->pconnect();
            // print "connect took " . (microtime(true) - $startTime) . PHP_EOL; 
            $startTime = microtime(true);
            $channel = new \AMQPChannel($connection);
            // print "channel took " . (microtime(true) - $startTime) . PHP_EOL;
            $startTime = microtime(true);
            $exchange = new \AMQPExchange($channel);
            // print "exchange took " . (microtime(true) - $startTime) . PHP_EOL;
            $exchange->setName('bench');
            $startTime = microtime(true);
            $exchange->publish($this->message . $i, 'bench');
            // print "publish took " . (microtime(true) - $startTime) . PHP_EOL;
            //print "Everything took " . (microtime(true) - $masterstartTime) . PHP_EOL . PHP_EOL;
        }
         $connection->pdisconnect();

    }


    protected function publishWithExtConnect($nbMessages)
    {
        for ($i = 0; $i < $nbMessages; $i++) {
            $connection = new \AMQPConnection([
                'vhost' => 'bench'
            ]);
            $connection->connect();
            $channel = new \AMQPChannel($connection);
            $exchange = new \AMQPExchange($channel);
            $exchange->setName('bench');
            $exchange->publish("message$i", 'bench');
            $connection->disconnect();
        }
    }

    protected function publishWithExt($nbMessages)
    {
        $connection = new \AMQPConnection([
            'vhost' => 'bench'
        ]);
        $connection->connect();
        $channel = new \AMQPChannel($connection);
        $exchange = new \AMQPExchange($channel);
        $exchange->setName('bench');

        for ($i = 0; $i < $nbMessages; $i++) {
            $exchange->publish("message$i", 'bench');
        }

        $connection->disconnect();
    }

    /**
     * publishWithLib
     *
     * @param int $nbMessages
     *
     * @return void
     */

    protected function publishWithLibConnect($nbMessages)
    {
        for ($i = 0; $i < $nbMessages; $i++) {
            $connection = new AMQPConnection('127.0.0.1', 5672, 'guest', 'guest', 'bench');
            $channel = $connection->channel();
            $channel->basic_publish(new AMQPMessage("message$i"), 'bench', 'bench');
            $channel->close();
            $connection->close();
        }
    }

    protected function publishWithLib($nbMessages)
    {
        $connection = new AMQPConnection('127.0.0.1', 5672, 'guest', 'guest', 'bench');
        $channel = $connection->channel();

        for ($i = 0; $i < $nbMessages; $i++) {
            $channel->basic_publish(new AMQPMessage("message$i"), 'bench', 'bench');
        }

        $channel->close();
        $connection->close();
    }
}
