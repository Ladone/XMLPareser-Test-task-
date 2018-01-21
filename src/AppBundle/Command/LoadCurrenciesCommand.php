<?php
/**
 * Created by PhpStorm.
 * User: Ladone
 * Date: 21.01.2018
 * Time: 18:44:58
 */

namespace AppBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SimpleXMLElement;
use AppBundle\Entity\Currency;
use AppBundle\Entity\CurrencyCode;

class LoadCurrenciesCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('app:load-сurrencies')

            // the short description shown while running "php app/console list"
            ->setDescription('Load new data from site NBU.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command load new data of currencies.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get container and entity manager
        $container = $this->getApplication()->getKernel()->getContainer();
        $em = $container->get('doctrine')->getManager();

        // get currencies
        $coursesSource = file_get_contents('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange');
        $courses = new SimpleXMLElement($coursesSource);

        // check currencies code in database
        $allCurrencyCodes = $em->getRepository(CurrencyCode::class)->findAll();
        $prepareCurrencyCodes = [];

        // load currencies
        foreach($courses->currency as $cours)
        {
            $currentCours = $em->getRepository(CurrencyCode::class)->findOneBy(['code' => $cours->cc]);
//            if(in_array($cours->cc, $prepareCurrencyCodes) == false)
            if(!$currentCours)
            {
                $newCode = new CurrencyCode();
                $newCode->setCode($cours->cc);
                $em->persist($newCode);
            }
        }

        $em->flush();

        // prepare currency codes
        foreach($allCurrencyCodes as $code)
        {
            $prepareCurrencyCodes[] = $code->getCode();
        }

        // prepare currencies
        foreach($courses->currency as $currency)
        {
            // check unick XML Exchange
            $currencyCode = $em->getRepository(CurrencyCode::class)->findOneBy(['code' => $currency->cc]);
            $currenciesInDB = $em->getRepository(Currency::class)->findBy(['date' => new \DateTime($currency->exchangedate), 'code' => $currencyCode]);
            if(!$currenciesInDB)
            {
                $newCurrency = new Currency();
                $newCurrency->setCode($currencyCode)
                    ->setDate(new \DateTime($currency->exchangedate))
                    ->setValue(floatval($currency->rate));

                $em->persist($newCurrency);
            }
        }
        $em->flush();

        $date = new \DateTime('now');
        $output->writeln('Data as already up-to-date '.$date->format('d.m.Y'));
    }
}