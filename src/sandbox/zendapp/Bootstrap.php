<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * initialize the application logger as a class resources.
     *
     * this will be replace with plugin resources after upgrade to Zend 1.11.x.
     */
    protected function _initApplicationLogger() {

        $config = new Zend_Config($this->getOptions());
        // set up logger for logging message.
        $writer = new Zend_Log_Writer_Stream($config->logging->stream
                                             ->writerParams->stream);
        $filter = new Zend_Log_Filter_Priority((int) $config->logging
                                               ->stream->filterParams
                                               ->priority);
        $formatter = new Zend_Log_Formatter_Simple($config->logging
                                                   ->stream->formatterParams
                                                   ->format . PHP_EOL);
        $writer->setFormatter($formatter);
        $logger = new Zend_Log($writer);
        $logger->addFilter($filter);
        $logger->setEventItem('pid', getmypid());
        Zend_Registry::set('logger', $logger);
        $logger->info("application logger initialization done!");

        unset($config);
        unset($logger);
        unset($writer);
        unset($filter);
        unset($formatter);
    }

    /**
     * Here is the start point for this application.
     */
    public function run() {

        Zend_Registry::set('config', new Zend_Config($this->getOptions()));
        $config = Zend_Registry::get('config');

        unset($config);

        parent::run();
    }
}