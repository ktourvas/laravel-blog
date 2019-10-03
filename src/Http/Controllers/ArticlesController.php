<?php

namespace ktourvas\LaravelBlog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ktourvas\LaravelBlog\Entities\Article;

use ktourvas\LaravelMediable\Http\Controllers\MediaController;

class ArticlesController {

    use MediaController;

    public function create(Request $request) {

        $article = $request->user()->articles()->create( $request->all() );

        $article->body()->create( $request->all() );

        foreach ($request->titles as $title) {

            $article->titles()->create( [
                'title' => $title['payload'],
                'type_id' => $title['type_id']
            ] );

        }

        return $article;

    }

    public function index(Request $request) {

        return Article::with(['titles', 'body'])->get();

    }

    public function view(Request $request, Article $article) {

        return $article->load('titles', 'body', 'media');

    }

    public function update(Request $request, Article $article) {

        foreach ($request->titles as $title) {

            $article->titles()->where('type_id', $title['type_id'])->update( [
                'title' => $title['payload'],
            ] );

        }

        $article->body()->update([
            'body' => $request->body
        ]);

        $article->slug = $request->slug;
        $article->save();

        return $article->toArray();

    }

    public function addMedia(Request $request, Article $article) {

        $article->media()->attach(
            $this->createMedia( $request )->id
        );

        $article->save();

    }


//    protected $promo;
//
//    public function __construct(Request $request)
//    {
//        if(!empty($request->utc_env)) {
//            \App::make('UnderTheCap\Promos')->setCurrent($request->utc_env);
//            $this->promo = \App::make('UnderTheCap\Promos')->current();
//        }
//
//    }
//
//    public function submitCode(Request $request) {
//        return $this->submit($request, 'redemption');
//    }
//
//    public function submit(Request $request, $submissionType = 'sole')
//    {
//
//        //Start by validating the promo status. Throws PromoStatusException if status !== r
//        $this->promo->validatePromoStatus();
//
//        // Validate the form submission. Despite of the type of submission a single set of validation rules is
//        // used for convenience.
//        $this->validate($request,
//            $this->promo->participationValidationRules()->toArray(),
//            $this->promo->participationValidationMessages()->toArray()
//        );
//
//        // If the submission type includes code redemption, validate the code of the submission
//        $code = null;
//        if( $submissionType == 'redemption' && !empty($request->code) ) {
//            $code = $this->getRedemptionCode($request->code);
//            if(empty($code)) {
//                throw new RedemptionCodeException($this->promo);
//            }
//        }
//
//        $participation = $this->createParticipation($request, $code);
//
//        $participation = $this->playInstant($participation);
//
//        // All went well, emit the ParticipationSubmitted event
//        if(!empty($participation)) {
//            event( new ParticipationSubmitted($participation) );
//        }
//
//        return [
//            'success' => !empty( $participation ),
//            'participation' => !empty( $participation ) ? $participation : null
//        ];
//
//    }
//
//    /**
//     * Retrieve a redemption code by code
//     * @param $code
//     * @return mixed
//     */
//    public function getRedemptionCode(String $code) {
//        return RedemptionCode::where('code', $code)->whereDoesntHave('participation')->first();
//    }
//
//    /**
//     * Run the instant win invokable and attach wins, if any, to the participation
//     * @param Participation $participation
//     * @return Participation
//     * @throws \UnderTheCap\Exceptions\PromoConfigurationException
//     */
//    private function playInstant(Participation $participation) {
//
//        if( $this->promo->instantDraws()->count() > 0 ) {
//
//            $instant = new InstantWinsManager();
//
//            foreach( $this->promo->instantDraws() as $id => $info ) {
//
//                if(
//                    Participation::whereHas('win', function($q) use ($id) {
//                        $q->where('type_id', $id);
//                    })
//                        ->where(function($q) use ($participation) {
//                            $q->where('email', $participation->email)
//                                ->orWhere('tel', $participation->tel);
//                        })
//                        ->count() == 0) {
//
//                    $win = $instant($id, $info);
//
//                    if( $win !== false) {
//
//                        $pwin = $participation->win()->create([
//                            'type_id' => $id,
//                            'present_id' => $win['id'],
//                            'confirmed' => (!empty($info['auto_approved']) &&  $info['auto_approved'] === true) ? 1 : 0
//                        ]);
//
//                        $winpresent = $pwin->winpresent()->create([
//                            'present_id' => $win['id']
//                        ]);
//
//                    }
//
//                }
//
//            }
//
//
//            $participation->load('win.winpresent.present');
//
//            if( $participation->win()->exists() ) {
//
//                $participation->win[0]->winpresent->present->load(['variants' => function($q) {
//                    $q->where( 'remaining', '>', 0);
//                }]);
//
//                if( count($participation->win[0]->winpresent->present->variants) == 1 ) {
//
//                    $participation->win[0]->winpresent->update([
//                        'variant_id' => $participation->win[0]->winpresent->present->variants[0]->id
//                    ]);
//
//                    $participation->win[0]->winpresent->present->variants[0]->update([
//                        'remaining' =>  \DB::raw(' remaining - 1 ')
//                    ]);
//
//                }
//
//            }
//
//
//
//        }
//        return $participation;
//    }
//
//    /**
//     * Create and return a new Participation.
//     *
//     * @param $request
//     * @param null $code
//     * @return Participation
//     */
//    private function createParticipation($request, $code = null) {
//
//        // Get the participation create associative array
//        $create = $this->participationCreateArray($request);
//
//        // Create a new participation associated with the user if there is one
//        $participation = $request->user('api') === null ?
//            Participation::create($create) :
//            $request->user('api')->participations()->create($create);
//
//        // If a code has been validated, assign it to the participation
//        if( !empty($code) ) {
//            $participation->redemptionCode()->associate($code);
//            $participation->save();
//        }
//
//        return $participation;
//    }
//
//    /**
//     * Create the associative array to be used for participation creation
//     * @param $request
//     * @return array
//     */
//    private function participationCreateArray($request) {
//        // Filter the promo participation fields excluding the code and anything else needed in future updates
//        $fields = collect($this->promo->participationFieldKeys())->reject(function ($field) {
//            return $field === 'code';
//        })
//            ->map(function ($field) {
//                return $field;
//            });
//
//        // Create the array for participation creation and feed it to the model create method
//        $create = [];
//        foreach ( $fields as $field) {
//            $create[$field] = $request->get($field);
//        }
//        return $create;
//    }
//
//
//    public function truncate() {
//        if(!\App::environment('production')) {
//            WinPresent::truncate();
//            Win::truncate();
//            Participation::truncate();
//        }
//    }

}
