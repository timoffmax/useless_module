<?php

namespace Timoffmax\Useless\Console\Command\Product;

use Timoffmax\Useless\Model\Product;
use Timoffmax\Useless\Model\ProductFactory;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AddCommand extends Command implements CommandInterface
{
    public const COMMAND_NAME = self::COMMAND_PREFIX . 'add';

    /** @var ProductFactory */
    private $productFactory;

    public function __construct(ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Create new timoffmax_useless product item')
            ->addArgument(
                self::INPUT_KEY_PRODUCT_ID,
                InputArgument::REQUIRED,
                'Original product ID'
            )
            ->addArgument(
                self::INPUT_KEY_ORIGINAL_PRICE,
                InputArgument::REQUIRED,
                'Original product price'
            )
            ->addArgument(
                self::INPUT_KEY_PRICE,
                InputArgument::REQUIRED,
                'Converted product price'
            )
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Product $product */
        $product = $this->productFactory->create();
        $product->setProductId($input->getArgument(self::INPUT_KEY_PRODUCT_ID));
        $product->setOriginalPrice($input->getArgument(self::INPUT_KEY_ORIGINAL_PRICE));
        $product->setPrice($input->getArgument(self::INPUT_KEY_PRICE));
        $product->setIsObjectNew(true);
        $product->save();

        return Cli::RETURN_SUCCESS;
    }
}
