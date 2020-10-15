<?php
/**
 * ValuesObject Class For Example Model
 */
class PostVO extends ValuesObject
{
    /**
     * Get Example ID
     *
     * @return int Example ID
     */
    public function getID(): int
    {
        return (int) $this->get('id');
    }

    /**
     * Get Foo Param Value
     *
     * @return string Foo Param Value
     */
    public function getFoo(): string
    {
        return (string) $this->get('foo');
    }

    /**
     * Set Foo Param Value
     *
     * @param string $value Foo Param Value
     *
     * @return bool Is Foo Param Value Set
     */
    public function setFoo(?string $value = null): bool
    {
        return $this->set('foo', $value);
    }
}
