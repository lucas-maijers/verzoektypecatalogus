<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\RequestType;
use App\Entity\Task;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class HuwelijksplannerFixtures extends Fixture
{
    private $commonGroundService;
    private $params;

    public function __construct(CommonGroundService $commonGroundService, ParameterBagInterface $params)
    {
        $this->commonGroundService = $commonGroundService;
        $this->params = $params;
    }

    public function load(ObjectManager $manager)
    {
        if (
            $this->params->get('app_domain') != "huwelijksplanner.online" && strpos($this->params->get('app_domain'), "huwelijksplanner.online") == false
        ) {
            return false;
        }

        /*
    	 *  Wijziging Naamsgebruik
    	 */

        // Aanpassen naamsgebruik
        $id = Uuid::fromString('4830cd4c-d8ce-4f8c-a8ad-f3dc821911f3');
        $request = new RequestType();
        $request->setOrganization('002220647');
        $request->setIcon('fas fa-user-tie');
        $request->setName('Wijziging Naamsgebruik');
        $request->setDescription('Met dit verzoek kunt u achternaam aanpassen');
        $request->setCaseType('1ca29793-b797-4d52-953b-2c231fb8a6cf');
        $request->setCamundaProces('Aanvraag_wijziging_naamgebruik_behandelen');
        $manager->persist($request);

        // Dit is hacky tacky karig
        $request->setId($id);
        $manager->persist($request);
        $manager->flush();
        $request = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);
        // einde hacky tacky

        $property = new Property();
        $property->setTitle('Partner 1');
        $property->setName('naamgebruikPartner1');
        $property->setIcon('fal fa-user');
        $property->setType('string');
        $property->setDescription('Welke naam wilt u');
        $property->setRequestType($request);
        $manager->persist($property);

        $property = new Property();
        $property->setTitle('Partner 2');
        $property->setName('naamgebruikPartner2');
        $property->setIcon('fal fa-user');
        $property->setType('string');
        $property->setDescription('Welke naam wilt partner 2');
        $property->setRequestType($request);
        $manager->persist($property);


        /*
    	 *  Babs andere gemeente
    	 */

        $id = Uuid::fromString('27f6ecf0-34bb-4100-a375-d14f2d5ee1d0');
        $request = new RequestType();
        $request->setOrganization('002220647');
        $request->setIcon('fas fa-user-tie');
        $request->setName('Aanvraag babs andere gemeente');
        $request->setDescription('Met dit verzoek kunt u een ambtenaar voor aan andere gemeente aanvragen');
        $request->setCaseType('43340378-1c3a-4605-8a64-aa90e400368a');
        $request->setCamundaProces('Aanvraag_eigen_babs_beedigd_behandelen');
        $manager->persist($request);

        // Dit is hacky tacky karig
        $request->setId($id);
        $manager->persist($request);
        $manager->flush();
        $request = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);
        // einde hacky tacky

        $stage1 = new Property();
        $stage1->setStart(true);
        $stage1->setTitle('Gegevens');
        $stage1->setIcon('fal fa-user');
        $stage1->setSlug('babs-andere-gemeente');
        $stage1->setType('array');
        $stage1->setIri('irc/assent');
        $stage1->setDescription('Wat zijn de adress gegevens van uw beoogde babs');
        $stage1->setRequestType($request);
        $manager->persist($stage1);


        /*
    	 *  Babs voor een dag
    	 */

        $id = Uuid::fromString('cdd7e88b-1890-425d-a158-7f9ec92c9508');
        $request = new RequestType();
        $request->setIcon('fas fa-user-tie');
        $request->setOrganization('002220647');
        $request->setName('Aanvraag babs (niet beëdigd)');
        $request->setDescription('Aanvraag babs (niet beëdigd)');
        $request->setCaseType('zaaktypen/86dcc827-db64-4466-8d83-5d2976a1926a');
        $request->setCamundaProces('Aanvraag_eigen_Babs_niet_beedigd_behandelen');
        $manager->persist($request);

        // Dit is hacky tacky karig
        $request->setId($id);
        $manager->persist($request);
        $manager->flush();
        $request = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);
        // einde hacky tacky

        $stage1 = new Property();
        $stage1->setStart(true);
        $stage1->setTitle('Gegevens');
        $stage1->setIcon('fal fa-user');
        $stage1->setSlug('babs-voor-een-dag');
        $stage1->setIri('irc/assent');
        $stage1->setType('array');
        $stage1->setDescription('Wat zijn de contact gegevens van uw beoogd BABS');
        $stage1->setRequestType($request);
        $manager->persist($stage1);

        /*
    	 *  Trouwlocatie
    	 */

        $id = Uuid::fromString('c8704ea6-4962-4b7e-8d4e-69a257aa9577');
        $aanvraagLocatie = new RequestType();
        $aanvraagLocatie->setIcon('fal fa-rings-wedding');
        $aanvraagLocatie->setOrganization('002220647');
        $aanvraagLocatie->setName('Aanvraag trouwlocatie');
        $aanvraagLocatie->setDescription('Melding voorgenomen huwelijk');
        $aanvraagLocatie->setCaseType('bb1e251f-d7a2-4d2a-a8e4-a7236336fcfd');
        $aanvraagLocatie->setCamundaProces('Aanvraag_eigen_locatie_behandelen');
        $manager->persist($aanvraagLocatie);
        $aanvraagLocatie->setId($id);
        $manager->persist($aanvraagLocatie);
        $manager->flush();
        $aanvraagLocatie = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);

        $property = new Property();
        $property->setStart(true);
        $property->setTitle('Afwijkende trouw locatie');
        $property->setName('afwijkende_trouw_locatie');
        $property->setSlug('afwijkende_trouw_locatie');
        $property->setIcon('fal fa-paper-plane');
        $property->setType('array');
        $property->setDescription('Wat zijn de gegevens van uw locatie');
        $property->setRequestType($aanvraagLocatie);
        $manager->persist($property);

        $property = new Property();
        $property->setTitle('Naam');
        $property->setName('locatieNaam');
        $property->setIcon('fal fa-paper-plane');
        $property->setType('string');
        $property->setDescription('Wat is de naam van uw beoogde locatie');
        $property->setRequestType($aanvraagLocatie);
        $manager->persist($property);

        $property = new Property();
        $property->setTitle('Telefoon');
        $property->setName('locatieTelefoon');
        $property->setIcon('fal fa-paper-plane');
        $property->setType('string');
        $property->setDescription('Wat is het telefoon nummer van uw beoogde locatie');
        $property->setRequestType($aanvraagLocatie);
        $manager->persist($property);

        $property = new Property();
        $property->setTitle('Adres');
        $property->setName('locatieAdres');
        $property->setIcon('fal fa-paper-plane');
        $property->setType('string');
        $property->setDescription('Wat is het adress van uw beoogde locatie');
        $property->setRequestType($aanvraagLocatie);
        $manager->persist($property);

        $property = new Property();
        $property->setTitle('Omschrijving');
        $property->setName('locatieOmschrijving');
        $property->setIcon('fal fa-paper-plane');
        $property->setType('string');
        $property->setDescription('Kunt u een korte omschrijving geven van uw beoogde locatie');
        $property->setRequestType($aanvraagLocatie);
        $manager->persist($property);

        /*
    	 *  Melding Voorgenomen huwelijk
    	 */

        $id = Uuid::fromString('146cb7c8-46b9-4911-8ad9-3238bab4313e');
        $meldingTrouwenNL = new RequestType();
        $meldingTrouwenNL->setIcon('fal fa-ring');
        $meldingTrouwenNL->setOrganization('002220647');
        $meldingTrouwenNL->setName('Melding voorgenomen huwelijk');
        $meldingTrouwenNL->setDescription('Melding voorgenomen huwelijk');
        $meldingTrouwenNL->setCaseType('13c5e8e1-27e2-47e0-96df-410541176623');
        $meldingTrouwenNL->setCamundaProces('Melding_voorgenomen_huwelijk_behandelen');
        $manager->persist($meldingTrouwenNL);
        $meldingTrouwenNL->setId($id);
        $manager->persist($meldingTrouwenNL);
        $manager->flush();
        $meldingTrouwenNL = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);

        // Bijbehorende taken die in de queu worden gezet
        $task = new Task();
        $task->setRequestType($meldingTrouwenNL);
        $task->setName('Verlopen melding');
        $task->setDescription('Deze task controleerd na 1 jaar het verlopen van de melding');
        $task->setCode('controleer_meldingin');
        $task->setEndpoint('trouwservice');
        $task->setType('POST');
        $task->setEvent('update');
        $task->setTimeInterval('P1Y');

        $manager->persist($task);

        $task = new Task();
        $task->setRequestType($meldingTrouwenNL);
        $task->setName('Informeer Verlopen melding');
        $task->setDescription('Deze task verstuurd na 300 dagen een waarschuwing voor het verlopen van de melding');
        $task->setCode('informeren verlopen melding');
        $task->setEndpoint('trouwservice');
        $task->setType('POST');
        $task->setEvent('update');
        $task->setTimeInterval('P300D');

        $manager->persist($task);

        $task = new Task();
        $task->setRequestType($meldingTrouwenNL);
        $task->setName('Bevestig naar burger');
        $task->setDescription('Deze ttaak bevestig het huwelijk naar de burger');
        $task->setCode('bevestig_huwelijk');
        $task->setEndpoint('trouwservice');
        $task->setType('POST');
        $task->setEvent('create');
        $task->setTimeInterval('P0D'); // vertraging vna 0 dagen = meteen

        $manager->persist($task);

        $stage0 = new Property();
        $stage0->setStart(true);
        $stage0->setTitle('Info');
        $stage0->setIcon('fas fa-ring');
        $stage0->setSlug('info-melding');
        $stage0->setDescription('Hier wordt de benodigde informatie weergegeven voor het indienen van een melding.');
        $stage0->setRequestType($meldingTrouwenNL);
        $manager->persist($stage0);

        $stage1 = new Property();
        $stage1->addPrevious($stage0);
        $stage1->setTitle('Datum');
        $stage1->setIcon('fas fa-calendar-day');
        $stage1->setSlug('datum-melding');
        $stage1->setType('boolean');
        $stage1->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
        $stage1->setRequestType($meldingTrouwenNL);
        $manager->persist($stage1);

        $stage2 = new Property();
        $stage2->addPrevious($stage1);
        $stage2->setTitle('Partners');
        $stage2->setIcon('fas fa-user-friends');
        $stage2->setSlug('partner-melding');
        $stage2->setIri('irc/assent');
        $stage2->setType('array');
        $stage2->setFormat('bsn');
        $stage2->setMinItems(2);
        $stage2->setMaxItems(2);
        $stage2->setRequired(true);
        $stage2->setDescription('Wie zijn de partners?');
        $stage2->setRequestType($meldingTrouwenNL);
        $manager->persist($stage2);

        $stage3 = new Property();
        $stage3->addPrevious($stage2);
        $stage3->setTitle('Getuigen');
        $stage3->setIcon('fas fa-users');
        $stage3->setSlug('getuige-melding');
        $stage3->setIri('irc/assent');
        $stage3->setType('array');
        $stage3->setFormat('bsn');
        $stage3->setMinItems(2);
        $stage3->setMaxItems(4);
        $stage3->setRequired(true);
        $stage3->setDescription('Wie zijn de getuigen van partner?');
        $stage3->setRequestType($meldingTrouwenNL);
        $manager->persist($stage3);

        $stage4 = new Property();
        $stage4->addPrevious($stage3);
        $stage4->setTitle('Indienen');
        $stage4->setIcon('fal fa-paper-plane');
        $stage4->setSlug('indienen-melding');
        $stage4->setDescription('Wie zijn de getuigen van partner?');
        $stage4->setRequestType($meldingTrouwenNL);
        $manager->persist($stage4);

        /*
    	 *  Omzetting (partnerschap naar huwelijk)
    	 */

        $id = Uuid::fromString('432d3e81-5930-4c21-ab7f-c5541c948525');
        $omzettingNL = new RequestType();
        $omzettingNL->setIcon('fal fa-rings-wedding');
        $omzettingNL->setOrganization('0000');
        $omzettingNL->setName('Omzetting');
        $omzettingNL->setDescription('Het omzetten van een bestaand partnerschap in een huwelijk.');
        $manager->persist($omzettingNL);
        $omzettingNL->setId($id);
        $manager->persist($omzettingNL);
        $manager->flush();
        $omzettingNL = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);

        $stage1 = new Property();
        $stage1->setStart(true);
        $stage1->setTitle('Datum');
        $stage1->setIcon('fas fa-calendar-day');
        $stage1->setSlug('datum');
        $stage1->setType('string');
        $stage1->setFormat('date');
        $stage1->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
        $stage1->setRequestType($omzettingNL);
        $manager->persist($stage1);

        $stage2 = new Property();
        $stage2->addPrevious($stage1);
        $stage2->setTitle('Partners');
        $stage2->setIcon('fas fa-user-friends');
        $stage2->setSlug('partner');
        $stage2->setType('array');
        $stage2->setFormat('bsn');
        $stage2->setMinItems(2);
        $stage2->setMaxItems(2);
        $stage2->setRequired(true);
        $stage2->setDescription('Wie zijn de getuigen van partner 2?');
        $stage2->setRequestType($omzettingNL);
        $manager->persist($stage2);

        $stage3 = new Property();
        $stage3->addPrevious($stage2);
        $stage3->setTitle('Indienen');
        $stage3->setIcon('fal fa-paper-plane');
        $stage3->setSlug('indienen');
        $stage3->setDescription('Wie zijn de getuigen van partner?');
        $stage3->setRequestType($meldingTrouwenNL);
        $manager->persist($stage3);

        /*
    	 *  Huwelijk Partnerschap
    	 */

        $id = Uuid::fromString('5b10c1d6-7121-4be2-b479-7523f1b625f1');
        $trouwenNL = new RequestType();
        $trouwenNL->setIcon('fal fa-rings-wedding');
        $trouwenNL->setOrganization('002220647');
        $trouwenNL->setName('Huwelijk / Partnerschap');
        $trouwenNL->setDescription('Huwelijk / Partnerschap');
        $trouwenNL->setUnique(true);
        $manager->persist($trouwenNL);
        $trouwenNL->setId($id);
        $manager->persist($trouwenNL);
        $manager->flush();
        $trouwenNL = $manager->getRepository('App:RequestType')->findOneBy(['id'=> $id]);

        // Bijbehorende taken die in de queu worden gezet
        $task = new Task();
        $task->setRequestType($trouwenNL);
        $task->setName('Activeren trouw service');
        $task->setDescription('Deze task triggerd de trouwservice voor aanvullende logica');
        $task->setCode('update');
        $task->setEndpoint('https://ts.dev.huewlijksplanner.online/web_hooks');
        $task->setType('POST');
        $task->setEvent('update');
        $task->setTimeInterval('P0D');

        $manager->persist($task);

        // Inladen van de kinderen
        /*
        $trouwenNL->addChild($aanvraagBabs);
        $trouwenNL->addChild($aanvraagLocatie);
        $trouwenNL->addChild($meldingTrouwenNL);
        */

        $stage0 = new Property();
        $stage0->setStart(true);
        $stage0->setTitle('Start Huwelijk');
        $stage0->setIcon('fas fa-ring');
        $stage0->setName('start_huwelijk');
        $stage0->setSlug('start_huwelijk');
        $stage0->setDescription('Wat moet u zo meteen invullen?');
        $stage0->setRequestType($trouwenNL);
        $manager->persist($stage0);

        $stage1 = new Property();
        $stage1->addPrevious($stage0);
        $stage1->setTitle('Ceremonie');
        $stage1->setName('type');
        $stage1->setIcon('fas fa-ring');
        $stage1->setSlug('ceremonie');
        $stage1->setType('string');
        $stage1->setFormat('string');
        $stage1->setMaxLength('12');
        $stage1->setMinLength('7');
        $stage1->setEnum(['trouwen', 'partnerschap', 'omzetten']);
        $stage1->setRequired(true);
        $stage1->setDescription('Selecteer een huwelijk of partnerschap?');
        $stage1->setRequestType($trouwenNL);
        $manager->persist($stage1);

        $stage2 = new Property();
        $stage2->addPrevious($stage1);
        $stage2->setTitle('Partners');
        $stage2->setIcon('fas fa-user-friends');
        $stage2->setSlug('partner');
        $stage2->setType('array');
        $stage2->setFormat('url');
        $stage2->setIri('irc/assent');
        $stage2->setMinItems(2);
        $stage2->setMaxItems(2);
        $stage2->setRequired(true);
        $stage2->setDescription('Wie zijn de getuigen van partner 2?');
        $stage2->setRequestType($trouwenNL);
        $manager->persist($stage2);

        $stage3 = new Property();
        $stage3->addPrevious($stage2);
        $stage3->setTitle('Plechtigheid  ');
        $stage3->setIcon('fas fa-glass-cheers');
        $stage3->setSlug('plechtigheid');
        $stage3->setType('string');
        $stage3->setFormat('url');
        $stage3->setIri('pdc/offer');
        $stage3->setRequired(true);
        $stage3->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage3->setRequestType($trouwenNL);
        $manager->persist($stage3);

        $stage4 = new Property();
        $stage4->addPrevious($stage3);
        $stage4->setTitle('Datum');
        $stage4->setIcon('fas fa-calendar-day');
        $stage4->setSlug('datum');
        $stage4->setType('string');
        $stage4->setFormat('date');
        $stage4->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
        $stage4->setRequestType($trouwenNL);
        $manager->persist($stage4);

        $stage5 = new Property();
        $stage5->addPrevious($stage4);
        $stage5->setTitle('Locatie');
        $stage5->setIcon('fas fa-building');
        $stage5->setSlug('locatie');
        $stage5->setType('string');
        $stage5->setFormat('uri');
        $stage5->setIri('pdc/offer');
        $stage5->setMaxLength('255');
        $stage5->setRequired(true);
        $stage5->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
        $stage5->setRequestType($trouwenNL);
        $manager->persist($stage5);

        $stage6 = new Property();
        $stage6->addPrevious($stage5);
        $stage6->setTitle('Ambtenaar');
        $stage6->setIcon('fas fa-user-tie');
        $stage6->setSlug('ambtenaar');
        $stage6->setType('string');
        $stage6->setFormat('url');
        $stage6->setIri('pdc/offer');
        $stage6->setMaxLength('255');
        $stage6->setRequired(true);
        $stage6->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
        $stage6->setRequestType($trouwenNL);
        $manager->persist($stage6);

        $stage7 = new Property();
        $stage7->addPrevious($stage6);
        $stage7->setTitle('Getuigen');
        $stage7->setIcon('fas fa-users');
        $stage7->setSlug('getuige');
        $stage7->setType('array');
        $stage7->setFormat('url');
        $stage7->setIri('irc/assent');
        $stage7->setMinItems(2);
        $stage7->setMaxItems(4);
        $stage7->setRequired(true);
        $stage7->setDescription('Wie zijn de getuigen van partner?');
        $stage7->setRequestType($trouwenNL);
        $manager->persist($stage7);

        $stage8 = new Property();
        $stage8->addPrevious($stage7);
        $stage8->setTitle('Extras');
        $stage8->setIcon('fas fa-gift');
        $stage8->setSlug('extra');
        $stage8->setType('array');
        $stage8->setFormat('url');
        $stage8->setIri('pdc/offer');
        $stage8->setMinItems(1);
        $stage8->setRequired(true);
        $stage8->setDescription('Wie zijn de getuigen van partner?');
        $stage8->setRequestType($trouwenNL);
        $manager->persist($stage8);

        $overige = new Property();
        $overige->addPrevious($stage8);
        $overige->setTitle('Overig');
        $overige->setIcon('fal fa-file-alt');
        $overige->setSlug('overig');
        $overige->setMinItems(3);
        $overige->setMaxItems(3);
        $overige->setType('array');
        $overige->setMinItems(4);
        $overige->setFormat('string');
        $overige->setDescription('Graag zouden wij u om wat extra informatie vragen');
        $overige->setRequestType($trouwenNL);
        $manager->persist($overige);

        $stage9 = new Property();
        $stage9->addPrevious($overige);
        $stage9->setTitle('Melding ');
        $stage9->setIcon('fas fa-envelope');
        $stage9->setSlug('melding');
        $stage9->setType('string');
        $stage9->setFormat('url');
        $stage9->setIri('vrc/request');
        $stage9->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage9->setRequestType($trouwenNL);
        $manager->persist($stage9);

        $stage10 = new Property();
        $stage10->addPrevious($stage9);
        $stage10->setTitle('Betaling ');
        $stage10->setName('Betalen');
        $stage10->setIcon('fas fa-cash-register');
        $stage10->setSlug('betalen');
        $stage10->setType('string');
        $stage10->setFormat('url');
        $stage10->setIri('bs/invoice');
        $stage10->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage10->setRequestType($trouwenNL);
        $manager->persist($stage10);

        $stage11 = new Property();
        $stage11->addPrevious($stage10);
        $stage11->setTitle('Reserveren ');
        $stage11->setIcon('fas fa-calendar-check');
        $stage11->setSlug('checklist');
        $stage11->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage11->setRequestType($trouwenNL);
        $manager->persist($stage11);

        $property = new Property();
        //$property->setId('');
        $property->setTitle('Bestelling');
        $property->setName('order');
        $property->setType('string');
        $property->setFormat('url');
        $property->setIri('orc/order');
        $property->setMaxLength('255');
        $property->setRequired(true);
        $property->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
        $property->setRequestType($trouwenNL);
        $manager->persist($property);

        $property = new Property();
        //$property->setId('');
        $property->setTitle('Leeftijd');
        $property->setType('string');
        $property->setFormat('url');
        $property->setIri('ptc/leeftijdscheckhuwelijk');
        $property->setRequired(true);
        $property->setDescription('Zijn bijde parnters op de trouwdatum meerderjarig');
        $property->setRequestType($trouwenNL);
        $manager->persist($property);

        $property = new Property();
        //$property->setId('');
        $property->setTitle('Curatele');
        $property->setType('string');
        $property->setFormat('url');
        $property->setIri('ptc/curatelecheckhuwelijk');
        $property->setRequired(true);
        $property->setDescription('Staan bijde partners niet onder curatele');
        $property->setRequestType($trouwenNL);
        $manager->persist($property);

        $property = new Property();
        //$property->setId('');
        $property->setTitle('Familiaregraad');
        $property->setType('string');
        $property->setFormat('url');
        $property->setIri('ptc/familiaregraadhuwelijk');
        $property->setRequired(true);
        $property->setDescription('Zijn bijde parnters geen fammilie dichter dan de 4e graad');
        $property->setRequestType($trouwenNL);
        $manager->persist($property);

        $property = new Property();
        //$property->setId('');
        $property->setTitle('schijnhuwelijk');
        $property->setType('array');
        $property->setFormat('url');
        $property->setIri('ptc/schijnhuwelijk');
        $property->setRequired(true);
        $property->setDescription('Hebben bijde partners aangegeven niet te trouwen onder dwang');
        $property->setRequestType($trouwenNL);
        $manager->persist($property);

        $property = new Property();
        //$property->setId('');
        $property->setTitle('Opmerkingen / Wensen');
        $property->setName('wensen');
        $property->setType('string');
        $property->setFormat('url');
        $property->setDescription('zijn er vanuit de partners nog opmerkingen of wensen?');
        $property->setRequestType($trouwenNL);
        $manager->persist($property);

        $manager->flush();
    }
}
