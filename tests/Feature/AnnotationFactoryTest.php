<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;


    public function test_annotation_belongs_to_matter(): void
    {

        // Arrange

        // Inject factories
        $annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
        $matterFactory = $this->app->make(MatterFactoryInterface::class);
        $lawFactory = $this->app->make(LawFactoryInterface::class);
        $matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
        $articleFactory = $this->app->make(ArticleFactoryInterface::class);

        $matter = $matterFactory->create('matter', '#001000');
        $law = $lawFactory->create('title', false);
        $article = $articleFactory->create($law,'title of the article', 'this is the text of the article');
        $matterRelationSchema = $matterRelationSchemaFactory->create();

        //Act
        $annotation = $annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $matterRelationSchema
        );

        // Assert
        $this->assertDatabaseHas('annotations', [
            'id' => $annotation->id,
            'article_id' => $article->id,
            'matter_id' => $matter->id,
            'text'=>'this is an annotation'
        ]);
        $this->assertEquals($article->id, $annotation->article->id);
        $this->assertEquals($matter->id, $annotation->matter->id);
        $this->assertEquals($annotation->matter, $matter);
        $this->assertEquals($annotation->article, $article);


    }


}
