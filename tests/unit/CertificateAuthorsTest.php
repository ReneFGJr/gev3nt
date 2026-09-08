<?php

use App\Libraries\CertificateAuthors;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/Libraries/CertificateAuthors.php';

final class CertificateAuthorsTest extends TestCase
{
    public function testReportedCertificateKeepsFirstSpellingAndOtherAuthors(): void
    {
        self::assertSame(
            'Verônica Mendonça da Silveira, Daiane Barrili dos Santos e Rene Faustino Gabriel Junior',
            CertificateAuthors::unique('Verônica Mendonça da Silveira, Veronica Mendonça da Silveira, Daiane Barrili dos Santos e Rene Faustino Gabriel Junior')
        );
    }

    public function testRepeatedAuthorBeforeConjunctionIsRemoved(): void
    {
        self::assertSame(
            'ROSA HELENA CUNHA VIDAL e Rene Faustino Gabriel Junior',
            CertificateAuthors::unique('ROSA HELENA CUNHA VIDAL, Rosa Helena Cunha Vidal e Rene Faustino Gabriel Junior')
        );
    }
    public function testNormalizationHandlesCaseWhitespaceAndDecomposedAccents(): void
    {
        self::assertSame(CertificateAuthors::key('Verônica Mendonça'), CertificateAuthors::key("  VERO\u{0302}NICA   MENDONÇA  "));
    }

    public function testDistinctNamesAndNameConjunctionsArePreserved(): void
    {
        self::assertSame('Ana Costa e Silva; Ana Costa', CertificateAuthors::unique('Ana Costa e Silva; Ana Costa'));
        self::assertSame('', CertificateAuthors::unique(''));
    }
}
