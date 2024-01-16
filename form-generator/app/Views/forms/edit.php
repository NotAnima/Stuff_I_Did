<style>
	textarea {
		height: 350px;
	}
</style>

<div class="col-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
	<h2>Form 1</h2>
	<div class="form">
		<form action="<?= base_url('forms/edit/') . esc($form_id) ?>" method="post">
			<?= csrf_field() ?>
			<textarea id="code-editor" name="form-edit"><?= esc($form) ?></textarea>
      <?php $rules = json_encode($form_rules, JSON_PRETTY_PRINT); ?>
      <textarea id="rule-editor" name="rules-edit"><?= $rules ?></textarea>
			<input type="submit" name="submit" value="Update Form" class="mt-4 btn btn-primary">
		</form>
	</div>
</div>

<script>
  var codeEditor = CodeMirror.fromTextArea(document.getElementById("code-editor"), {
    mode: "htmlmixed",
    theme: "default",
    lineNumbers: true,
    tabSize: 4,
    extraKeys: {
        "Enter": function(cm) {
          cm.replaceSelection("\n");
        }
      }
  });
  var ruleEditor = CodeMirror.fromTextArea(document.getElementById("rule-editor"), {
    mode: "htmlmixed",
    theme: "default",
    lineNumbers: true,
    tabSize: 4,
    extraKeys: {
        "Enter": function(cm) {
          cm.replaceSelection("\n");
        }
      }
  });
</script>
