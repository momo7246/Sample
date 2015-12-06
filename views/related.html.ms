{#hasRelated}}
<div class="related">
    <section class="container">
        <div class="contents">
            <div class="columned-content">
                <div class="columned-content-row">
                    <section class="main-content">
                        <h4 class="title">{{#T}}Sample{{/T}}</h4>
                          <ul class="listing-items">
                          {{#related}}
                              <li class="listing-item>
                                {{{.}}}
                              </li>
                          {{/related}}
                          </ul>
                        </div>
                    </section>
                    <aside class="right-content"></aside>
                </div>
            </div>
        </div>
    </section>
</div>
{{/hasRelated}}