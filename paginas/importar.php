
<style>
:root{
--bg:#f6f8fb; --card:#ffffff; --accent:#6c63ff; --muted:#7b7f86; --success:#16a34a;
--glass: rgba(255,255,255,0.55);
}

.wrap{width:420px;max-width:96%;
    margin:0 auto;
}
.card{background:var(--card);border-radius:14px;padding:26px;box-shadow:0 10px 30px rgba(18,25,40,0.08);border:1px solid rgba(99,102,241,0.06)}


.brand{display:flex;align-items:center;gap:12px;margin-bottom:14px}
.logo{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--accent),#8e7bff);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
.tituloForm{margin:0;font-size:18px;font-weight:600}
p.lead{margin:4px 0 18px;color:var(--muted);font-size:13px}


.row{margin-bottom:12px}
label{display:block;font-size:13px;color:#333;margin-bottom:8px}
.inputs{display:flex;gap:10px}
select, input[type="number"]{flex:1;padding:10px;border-radius:8px;border:1px solid #e6e9ef;background:transparent;font-size:14px}


.filebox{display:flex;align-items:center;gap:12px;padding:12px;border-radius:10px;border:1px dashed #e3e6ee;background:linear-gradient(180deg,rgba(108,99,255,0.03),transparent);}
.filebox input[type=file]{display:none}
.filebtn{padding:8px 12px;border-radius:8px;background:var(--accent);color:#fff;border:none;cursor:pointer;font-weight:600}
.fileinfo{font-size:13px;color:var(--muted)}


.actions{display:flex;justify-content:space-between;align-items:center;margin-top:16px}
.note{font-size:12px;color:var(--muted)}
button.send{background:linear-gradient(90deg,var(--accent),#8e7bff);border:none;color:#fff;padding:10px 16px;border-radius:10px;cursor:pointer;font-weight:700;box-shadow:0 8px 18px rgba(108,99,255,0.12)}


.status{margin-top:14px;font-size:13px}
.progress{height:8px;background:#eef1ff;border-radius:999px;overflow:hidden;margin-top:8px}
.bar{height:100%;width:0%;background:linear-gradient(90deg,#00d4a3,var(--accent));border-radius:999px}


.foot{margin-top:12px;font-size:12px;color:var(--muted);text-align:center}


@media (max-width:480px){.inputs{flex-direction:column}}
</style>

<div class="wrap">
<div class="card">
<div class="brand">
<div class="logo">PL</div>
<div>
<h1>Upload de Planilha</h1>
<p class="lead">Envie sua planilha macro habilitada (.xlsm). Será salva como <code>arquivo/planilha.xlsm</code></p>
</div>
</div>


<form id="uploadForm">
<div class="row inputs">
<div style="flex:1">
<label for="mes">Mês</label>
<select id="mes" name="mes" required>
<option value="">-- selecione --</option>
<option value="1">Jan</option>
<option value="2">Fev</option>
<option value="3">Mar</option>
<option value="4">Abr</option>
<option value="5">Mai</option>
<option value="6">Jun</option>
<option value="7">Jul</option>
<option value="8">Ago</option>
<option value="9">Set</option>
<option value="10">Out</option>
<option value="11">Nov</option>
<option value="12">Dez</option>
</select>
</div>


<div style="width:120px">
<label for="ano">Ano</label>
<input type="number" id="ano" name="ano" min="1900" max="2100" required />
</div>
</div>


<div class="row">
<label>Arquivo (.xlsm)</label>
<div class="filebox">
<div>
<div class="fileinfo" id="fileName">Nenhum arquivo selecionado</div>
<div class="small" style="color:var(--muted);font-size:12px">Máx: 10MB — só .xlsm</div>
</div>
<div style="margin-left:auto">
<label class="filebtn" for="fileInput">Escolher</label>
<input type="file" id="fileInput" name="file" accept=".xlsm,application/vnd.ms-excel.sheet.macroEnabled.12" />
</div>
</div>
</div>


<div class="actions">
<div class="note">Verifique mês/ano antes de enviar</div>
<button class="send" type="submit" id="sendBtn">Enviar</button>
</div>


<div class="status" id="status" aria-live="polite"></div>
<div class="progress" style="display:none"><div class="bar" id="bar"></div></div>


</form>


<div class="foot">Deseja outra cor ou layout? Peça que eu ajuste.</div>
</div>
</div>

