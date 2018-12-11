<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\ORM\Util\Collection;

use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Spiral\ORM\Promise\PromiseInterface;

/**
 * LazyLoading collection build at top of data promise.
 */
class CollectionPromise extends AbstractLazyCollection implements PromisedInterface
{
    /** @var PromiseInterface */
    protected $promise;

    /**
     * @param PromiseInterface $promise
     */
    public function __construct(PromiseInterface $promise)
    {
        $this->promise = $promise;
    }

    /**
     * @inheritdoc
     */
    public function toPromise(): PromiseInterface
    {
        return $this->promise;
    }

    /**
     * @inheritdoc
     */
    protected function doInitialize()
    {
        $this->collection = new ArrayCollection($this->promise->__resolve());
    }
}