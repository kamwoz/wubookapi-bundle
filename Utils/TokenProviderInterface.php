<?php

namespace Kamwoz\WubookAPIBundle\Utils;

interface TokenProviderInterface
{
    public function getToken();

    public function setToken($token);

    public function removeCurrentSavedToken();
}