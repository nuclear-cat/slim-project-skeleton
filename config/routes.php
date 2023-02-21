<?php declare(strict_types=1);

use App\Http\Action;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return new class {
    private const UUID_REGEX = '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}';

    public function __invoke(App $app): void
    {
        $app->get('/', Action\HomeAction::class);

        $app->group('/v1', function (RouteCollectorProxy $group): void {
            $group->group('/video_meeting', function (RouteCollectorProxy $group): void {
                $group->post('/create', Action\VideoMeeting\CreateAction::class);
                $group->get('/{id:' . self::UUID_REGEX . '}', Action\VideoMeeting\IndexAction::class);
            });
        });
    }
};
