<div class="columns">

    <div class="column">

        <form action="/api/blog/{{ $article->id }}" method="post" autocomplete="off">

            <input type="hidden" name="_method" value="put">

            <div class="field">

                <label class="label">
                    URL Slug
                </label>

                <div class="control">
                    <input name="slug" class="input" type="text" placeholder="Article url slug" value="{{ $article->slug }}">
                </div>

            </div>

            @foreach( config('laravel-blog.titles') as $index => $title)

                <div class="field">

                    <label class="label">
                        {{ $title['legend'] }}
                    </label>

                    <div class="control">
                        <input name="title[{{ $title['type_id'] }}]"
                               class="input" type="text" placeholder="Text input"
                               value="{{ $article->titles()->where('type_id', $title['type_id'])->first()->title ?? '' }}">
                    </div>

                </div>

            @endforeach

            <div class="field">

                <label class="label">
                    Article Body
                </label>

                <div class="control">
                    <textarea class="textarea" placeholder="Textarea">
                        {{ $article->body()->body ?? '' }}
                    </textarea>
                </div>

            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link" type="submit">
                        Submit
                    </button>
                </div>
            </div>

        </form>

    </div>

    <div class="column">

    </div>

</div>
