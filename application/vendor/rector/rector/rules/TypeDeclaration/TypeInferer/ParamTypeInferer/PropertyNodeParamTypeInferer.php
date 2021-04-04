<?php

declare(strict_types=1);

namespace Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;

final class PropertyNodeParamTypeInferer implements ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;

    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;

    /**
     * @var TypeFactory
     */
    private $typeFactory;

    public function __construct(
        PropertyFetchAnalyzer $propertyFetchAnalyzer,
        NodeNameResolver $nodeNameResolver,
        SimpleCallableNodeTraverser $simpleCallableNodeTraverser,
        NodeTypeResolver $nodeTypeResolver,
        TypeFactory $typeFactory
    ) {
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeFactory = $typeFactory;
    }

    public function inferParam(Param $param): Type
    {
        $classLike = $param->getAttribute(AttributeKey::CLASS_NODE);
        if (! $classLike instanceof Class_) {
            return new MixedType();
        }

        $paramName = $this->nodeNameResolver->getName($param);

        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(AttributeKey::PARENT_NODE);

        $propertyStaticTypes = [];

        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod, function (Node $node) use (
            $paramName,
            &$propertyStaticTypes
        ) {
            if (! $node instanceof Assign) {
                return null;
            }

            if (! $this->propertyFetchAnalyzer->isVariableAssignToThisPropertyFetch($node, $paramName)) {
                return null;
            }

            $staticType = $this->nodeTypeResolver->getStaticType($node->var);

            if ($staticType !== null) {
                $propertyStaticTypes[] = $staticType;
            }

            return null;
        });

        return $this->typeFactory->createMixedPassedOrUnionType($propertyStaticTypes);
    }
}
