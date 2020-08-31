<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\PayPalPlugin\Api;

use Sylius\PayPalPlugin\Client\PayPalClientInterface;

final class UpdateOrderApi implements UpdateOrderApiInterface
{
    /** @var PayPalClientInterface */
    private $client;

    public function __construct(PayPalClientInterface $client)
    {
        $this->client = $client;
    }

    public function update(string $token, string $orderId, string $newTotal, string $newCurrencyCode): void
    {
        $this->client->patch(
            sprintf('v2/checkout/orders/%s', $orderId),
            $token,
            [
                [
                    'op' => 'replace',
                    'path' => '/purchase_units/@reference_id==\'default\'/amount',
                    'value' => ['value' => $newTotal, 'currency_code' => $newCurrencyCode],
                ],
            ]
        );
    }
}
