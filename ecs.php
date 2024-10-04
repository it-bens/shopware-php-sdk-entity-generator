<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixerCustomFixers\Fixer\NoImportFromGlobalNamespaceFixer;
use PhpCsFixerCustomFixers\Fixer\NoSuperfluousConcatenationFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocNoIncorrectVarAnnotationFixer;
use PhpCsFixerCustomFixers\Fixer\SingleSpaceAfterStatementFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(SetList::COMMON);
    $ecsConfig->import(SetList::CLEAN_CODE);
    $ecsConfig->import(SetList::SYMPLIFY);
    $ecsConfig->import(SetList::PSR_12);
    $ecsConfig->import(SetList::DOCTRINE_ANNOTATIONS);

    $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
        LineLengthFixer::LINE_LENGTH => 140,
    ]);
    $ecsConfig->rule(StandaloneLinePromotedPropertyFixer::class);
    $ecsConfig->rule(NoImportFromGlobalNamespaceFixer::class);
    $ecsConfig->rule(NoSuperfluousConcatenationFixer::class);
    $ecsConfig->rule(NoUselessCommentFixer::class);
    $ecsConfig->rule(PhpdocNoIncorrectVarAnnotationFixer::class);
    $ecsConfig->rule(SingleSpaceAfterStatementFixer::class);
    $ecsConfig->ruleWithConfiguration(GeneralPhpdocAnnotationRemoveFixer::class, [
        'annotations' => ['copyright', 'category'],
    ]);
};
