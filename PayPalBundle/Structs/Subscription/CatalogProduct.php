<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription;

class CatalogProduct
{
    const TYPE_PHYSICAL = 'PHYSICAL';
    const TYPE_DIGITAL = 'DIGITAL';
    const TYPE_SERVICE = 'SERVICE';

    const TYPES = [
        self::TYPE_PHYSICAL,
        self::TYPE_DIGITAL,
        self::TYPE_SERVICE,
    ];

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type = self::TYPE_PHYSICAL;

    /**
     * @param string|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $type
     * @phpstan-param self::TYPE_* $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
