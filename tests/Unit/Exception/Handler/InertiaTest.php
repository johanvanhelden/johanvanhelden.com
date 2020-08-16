<?php

declare(strict_types=1);

namespace Tests\Unit\Exception\Handler;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mockery;
use Mockery\LegacyMockInterface;
use stdClass;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class InertiaTest extends TestCase
{
    private Request $request;

    private LegacyMockInterface $response;

    private Handler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = Request::create('/awesome-test', 'GET');
        $this->response = Mockery::mock(stdClass::class);
        $this->handler = $this->app->make(Handler::class);
    }

    /** @test */
    public function will_render_an_inertia_page_if_it_should(): void
    {
        $this->request->headers->add(['X-Inertia' => 'true']);
        $this->request->headers->add(['X-Inertia-Partial-Component' => 'User/Edit']);
        $this->request->headers->add(['X-Inertia-Partial-Data' => 'partial']);

        App::shouldReceive('environment')->once()->andReturn(false);
        App::shouldReceive('call')->andReturn(null);

        $response = $this->handler->render($this->request, new NotFoundHttpException());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('Error', $data['component']);
        $this->assertEquals(404, $data['props']['status']);
        $this->assertEquals('/awesome-test', $data['url']);
    }

    /** @test */
    public function should_go_to_an_inertia_page_on_production_inside_inertia_with_a_404_exception(): void
    {
        $this->request->headers->add(['X-Inertia' => 'true']);
        $this->response->shouldReceive('getStatusCode')->once()->andReturn(404);

        App::shouldReceive('environment')->once()->andReturn(false);

        $this->assertTrue($this->handler->shouldGoToInertiaErrorPage($this->request, $this->response));
    }

    /** @test */
    public function should_not_go_to_an_inertia_page_on_production_outside_of_inertia(): void
    {
        App::shouldReceive('environment')->once()->andReturn(false);

        $this->assertFalse($this->handler->shouldGoToInertiaErrorPage($this->request, $this->response));
    }

    /** @test */
    public function should_not_go_to_an_inertia_page_on_local(): void
    {
        $this->request->headers->add(['X-Inertia' => 'true']);

        App::shouldReceive('environment')->once()->andReturn(true);

        $this->assertFalse($this->handler->shouldGoToInertiaErrorPage($this->request, $this->response));
    }
}
