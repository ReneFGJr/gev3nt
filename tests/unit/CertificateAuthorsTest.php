<?php

use App\Libraries\CertificateAuthors;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/Libraries/CertificateAuthors.php';
require_once __DIR__ . '/../../app/Helpers/nbr_helper.php';

final class CertificateAuthorsTest extends TestCase
{
    public function testPdfNormalizesCaseAndRemovesRepeatedAuthor(): void
    {
        self::assertSame(
            'Rosa Helena Cunha Vidal e Rene Faustino Gabriel Junior',
            CertificateAuthors::forPdf('ROSA HELENA CUNHA VIDAL, Rosa Helena Cunha Vidal E RENE FAUSTINO GABRIEL JUNIOR')
        );
    }

    public function testPdfPreservesAccentsParticlesAndSeparators(): void
    {
        self::assertSame(
            'Verônica Mendonça da Silveira, Daiane Barrili dos Santos e Rene Faustino Gabriel Junior',
            CertificateAuthors::forPdf('VERÔNICA MENDONÇA DA SILVEIRA, Veronica Mendonça da Silveira, DAIANE BARRILI DOS SANTOS E RENE FAUSTINO GABRIEL JUNIOR')
        );
        self::assertSame('Álvaro de Sá', nbr_author(' ÁLVARO  DE SÁ ', 3));
        self::assertSame('', CertificateAuthors::forPdf(''));
    }
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
