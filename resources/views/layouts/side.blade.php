<div class="top-side">
	<div class="tag-ranking">
		<div class="tag-ranking-header">
			タグ・ランキング
		</div>
		<ul class="tag-ranking-body">
			@foreach ($ranking_tag_list as $tag_list)
			<li>
				<ul class="tag-ranking-ul">
					<li class="tag-ranking-li">
						@if ($loop->iteration === 1)
						<i class="fas fa-crown gold"></i>
						@elseif($loop->iteration === 2)
						<i class="fas fa-crown silver"></i>
						@elseif($loop->iteration === 3)
						<i class="fas fa-crown bronze"></i>
						@else
						{{$loop->iteration}}
						@endif
					</li>
					<li class="tag-ranking-li"><a href="/tag/{{$tag_list['tag_id']}}">{{$tag_list['tag_name']}}</a></li>
					<li class="tag-ranking-li">
						<div>
							<p class="number-tag">{{$tag_list['count_tag_id']}}</p>
							<p class="posts">Posts</p>
						</div>
					</li>
				</ul>
			</li>
			@endforeach
		</ul>
	</div>
</div>
